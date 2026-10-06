$ErrorActionPreference = "Stop"
Set-StrictMode -Version Latest

$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

function Invoke-NativeQuiet {
    param(
        [Parameter(Mandatory = $true)]
        [scriptblock]$Command
    )

    $oldPreference = $ErrorActionPreference
    try {
        # Windows PowerShell 5.x can convert native stderr into
        # NativeCommandError when ErrorActionPreference=Stop.
        # Temporarily suppress that conversion and rely on LASTEXITCODE.
        $ErrorActionPreference = "SilentlyContinue"
        & $Command *> $null
        return $LASTEXITCODE
    }
    finally {
        $ErrorActionPreference = $oldPreference
    }
}

function Invoke-Native {
    param(
        [Parameter(Mandatory = $true)]
        [scriptblock]$Command
    )

    $oldPreference = $ErrorActionPreference
    try {
        $ErrorActionPreference = "Continue"

        # Send command output directly to the host so assignments like:
        #   $code = Invoke-Native { docker ... }
        # capture ONLY the numeric exit code.
        & $Command 2>&1 | Out-Host
        $code = $LASTEXITCODE

        return [int]$code
    }
    finally {
        $ErrorActionPreference = $oldPreference
    }
}

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    throw "Docker is not available in PATH. Install/start Docker Desktop first."
}

$dockerOk = Invoke-NativeQuiet { docker version --format "{{.Server.Version}}" }
if ($dockerOk -ne 0) {
    throw "Docker Engine is not running."
}

$envMap = @{}
Get-Content ".env" | ForEach-Object {
    if ($_ -match '^\s*([^#][^=]*)=(.*)$') {
        $envMap[$matches[1].Trim()] = $matches[2].Trim()
    }
}

$wpPort = $envMap["WP_PORT"]
$adminUser = $envMap["WP_ADMIN_USER"]
$adminPass = $envMap["WP_ADMIN_PASSWORD"]
$adminEmail = $envMap["WP_ADMIN_EMAIL"]

Write-Host "Starting SakhtYar Flow local stack..." -ForegroundColor Cyan
$upCode = Invoke-Native { docker compose up -d db wordpress phpmyadmin }
if ($upCode -ne 0) {
    throw "docker compose up failed with exit code $upCode"
}

Write-Host "Waiting for WordPress..." -ForegroundColor Cyan
$ready = $false
for ($i = 0; $i -lt 60; $i++) {
    try {
        $r = Invoke-WebRequest -Uri "http://localhost:$wpPort" -UseBasicParsing -TimeoutSec 3
        if ($r.StatusCode -ge 200 -and $r.StatusCode -lt 500) {
            $ready = $true
            break
        }
    }
    catch {
        Start-Sleep -Seconds 2
    }
}

if (-not $ready) {
    throw "WordPress did not become reachable. Run: docker compose logs wordpress"
}

# Check whether WordPress is already installed.
$installedCode = Invoke-NativeQuiet {
    docker compose run --rm wpcli core is-installed --allow-root
}

if ($installedCode -ne 0) {
    Write-Host "Installing WordPress locally..." -ForegroundColor Cyan

    $installCode = Invoke-Native {
        docker compose run --rm wpcli core install `
            --url="http://localhost:$wpPort" `
            --title="SakhtYar Flow Local" `
            --admin_user="$adminUser" `
            --admin_password="$adminPass" `
            --admin_email="$adminEmail" `
            --skip-email `
            --allow-root
    }

    if ($installCode -ne 0) {
        throw "WordPress installation failed with exit code $installCode."
    }
}
else {
    Write-Host "WordPress is already installed." -ForegroundColor DarkGreen
}

Write-Host "Activating SakhtYar Flow theme..." -ForegroundColor Cyan
$themeCode = Invoke-Native {
    docker compose run --rm wpcli theme activate sakhtyar-flow --allow-root
}
if ($themeCode -ne 0) {
    throw "Theme activation failed with exit code $themeCode."
}

Invoke-NativeQuiet {
    docker compose run --rm wpcli option update timezone_string "Asia/Tehran" --allow-root
} | Out-Null

Invoke-NativeQuiet {
    docker compose run --rm wpcli option update start_of_week "6" --allow-root
} | Out-Null

Invoke-NativeQuiet {
    docker compose run --rm wpcli option update blog_public "0" --allow-root
} | Out-Null

Invoke-NativeQuiet {
    docker compose run --rm wpcli rewrite structure '/%postname%/' --hard --allow-root
} | Out-Null

Write-Host ""
Write-Host "Local site is ready." -ForegroundColor Green
Write-Host "Site:       http://localhost:$wpPort"
Write-Host "Admin:      http://localhost:$wpPort/wp-admin"
Write-Host "phpMyAdmin: http://localhost:$($envMap["PMA_PORT"])"
Write-Host ""
Write-Host "Local admin user: $adminUser"
Write-Host "Local admin password is stored only in .env (ignored by Git)."