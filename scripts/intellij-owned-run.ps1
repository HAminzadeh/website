param(
    [switch]$NoBrowser
)

$ErrorActionPreference = "Stop"
Set-StrictMode -Version Latest

$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

function Step([string]$Text) {
    Write-Host ""
    Write-Host "==> $Text" -ForegroundColor Cyan
}

function DockerReady {
    try {
        $v = (& docker version --format '{{.Server.Version}}' 2>$null | Out-String).Trim()
        return ($LASTEXITCODE -eq 0 -and -not [string]::IsNullOrWhiteSpace($v))
    } catch { return $false }
}

function EnsureDocker {
    if (DockerReady) { return }

    $paths = @(
        "$env:ProgramFiles\Docker\Docker\Docker Desktop.exe",
        "$env:LOCALAPPDATA\Docker\Docker Desktop.exe"
    ) | Where-Object { $_ -and (Test-Path $_) }
    $paths = @($paths)

    if ($paths.Count -eq 0) {
        throw "Docker Desktop is not installed."
    }

    if (@(Get-Process -Name "Docker Desktop" -ErrorAction SilentlyContinue).Count -eq 0) {
        Start-Process $paths[0] | Out-Null
    }

    for ($i=0; $i -lt 90; $i++) {
        if (DockerReady) { return }
        Start-Sleep -Seconds 2
    }
    throw "Docker Engine did not become ready."
}

function NativeExit([scriptblock]$Command) {
    $old = $ErrorActionPreference
    try {
        $ErrorActionPreference = "Continue"
        & $Command 2>&1 | Out-Host
        return [int]$LASTEXITCODE
    } finally {
        $ErrorActionPreference = $old
    }
}

Step "Starting SakhtYar Flow as an IntelliJ-owned process"
EnsureDocker

# Always begin clean: no old project containers should survive from a previous session.
NativeExit { docker compose down --remove-orphans } | Out-Null

# Start temporarily in background only for WordPress bootstrap.
$code = NativeExit { docker compose up -d db wordpress phpmyadmin }
if ($code -ne 0) { throw "Could not start local containers." }

try {
    Step "Waiting for WordPress"
    $ready = $false
    for ($i=0; $i -lt 60; $i++) {
        try {
            $r = Invoke-WebRequest "http://localhost:8080" -UseBasicParsing -TimeoutSec 3
            if ($r.StatusCode -ge 200 -and $r.StatusCode -lt 500) { $ready = $true; break }
        } catch {
            Start-Sleep -Seconds 2
        }
    }
    if (-not $ready) { throw "WordPress did not become reachable." }

    Step "Preparing WordPress"
    $installed = NativeExit { docker compose run --rm wpcli core is-installed --allow-root }
    if ($installed -ne 0) {
        $envMap = @{}
        Get-Content ".env" | ForEach-Object {
            if ($_ -match '^\s*([^#][^=]*)=(.*)$') {
                $envMap[$matches[1].Trim()] = $matches[2].Trim()
            }
        }

        $install = NativeExit {
            docker compose run --rm wpcli core install `
                --url="http://localhost:$($envMap['WP_PORT'])" `
                --title="SakhtYar Flow Local" `
                --admin_user="$($envMap['WP_ADMIN_USER'])" `
                --admin_password="$($envMap['WP_ADMIN_PASSWORD'])" `
                --admin_email="$($envMap['WP_ADMIN_EMAIL'])" `
                --skip-email `
                --allow-root
        }
        if ($install -ne 0) { throw "WordPress install failed." }
    }

    NativeExit { docker compose run --rm wpcli theme activate sakhtyar-flow --allow-root } | Out-Null
    NativeExit { docker compose run --rm wpcli option update timezone_string "Asia/Tehran" --allow-root } | Out-Null
    NativeExit { docker compose run --rm wpcli option update start_of_week "6" --allow-root } | Out-Null
    NativeExit { docker compose run --rm wpcli option update blog_public "0" --allow-root } | Out-Null
    NativeExit { docker compose run --rm wpcli rewrite structure '/%postname%/' --hard --allow-root } | Out-Null
    Step "Synchronizing current IntelliJ project into WordPress"
    & powershell.exe -NoProfile -ExecutionPolicy Bypass -File (Join-Path $Root "scripts\sync-wordpress.ps1")
    if ($LASTEXITCODE -ne 0) { throw "Project-to-WordPress sync failed." }


    if (-not $NoBrowser) {
        Start-Process "http://localhost:8080"
    }

    Write-Host ""
    Write-Host "SakhtYar Flow is RUNNING." -ForegroundColor Green
    Write-Host "Use IntelliJ's red STOP button to stop the site." -ForegroundColor Yellow
    Write-Host "When this run session ends, localhost:8080 will be shut down." -ForegroundColor Yellow
    Write-Host ""

    # Switch to foreground ownership. IntelliJ now owns the compose process.
    # When IntelliJ stops this Run Configuration, docker compose receives termination
    # and stops the project containers.
    NativeExit { docker compose stop } | Out-Null
# A detached watchdog owns cleanup. Even if IntelliJ forcibly terminates this
# PowerShell process, the watchdog notices and runs docker compose down.
$watchdog = Join-Path $PSScriptRoot "intellij-stop-watchdog.ps1"
$watchdogArgs = "-NoProfile -ExecutionPolicy Bypass -File `"$watchdog`" -ParentPid $PID -RepoRoot `"$Root`""
Start-Process -FilePath "powershell.exe" -ArgumentList $watchdogArgs -WindowStyle Hidden | Out-Null

docker compose up
}
finally {
    Step "Stopping SakhtYar Flow containers"
    $old = $ErrorActionPreference
    try {
        $ErrorActionPreference = "SilentlyContinue"
        docker compose down --remove-orphans *> $null
    } finally {
        $ErrorActionPreference = $old
    }
}
