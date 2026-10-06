$ErrorActionPreference = "Stop"
Set-StrictMode -Version Latest

$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

$ManagedNodeVersion = "22.12.0"
$NodeArchiveName = "node-v$ManagedNodeVersion-win-x64.zip"
$NodeFolderName = "node-v$ManagedNodeVersion-win-x64"

$ToolsRoot = Join-Path $Root ".runtime\tools"
$Downloads = Join-Path $Root ".runtime\downloads"
$NodeDir = Join-Path $ToolsRoot $NodeFolderName
$NodeExe = Join-Path $NodeDir "node.exe"
$NpmExe = Join-Path $NodeDir "npm.cmd"
$Archive = Join-Path $Downloads $NodeArchiveName
$NpmCache = Join-Path $Root ".runtime\npm-cache"

function Step([string]$Text) {
    Write-Host ""
    Write-Host "==> $Text" -ForegroundColor Cyan
}

function Fail([string]$Text) {
    Write-Host ""
    Write-Host "ERROR: $Text" -ForegroundColor Red
    exit 1
}

function Ensure-ManagedNode {
    if ((Test-Path $NodeExe) -and (Test-Path $NpmExe)) {
        $v = (& $NodeExe --version).Trim()
        Write-Host "Managed Node.js ready: $v" -ForegroundColor Green
        return
    }

    Step "Preparing project-managed Node.js $ManagedNodeVersion"
    New-Item -ItemType Directory -Force -Path $ToolsRoot,$Downloads | Out-Null

    if (-not (Test-Path $Archive)) {
        $url = "https://nodejs.org/dist/v$ManagedNodeVersion/$NodeArchiveName"
        Write-Host "Downloading portable Node.js..." -ForegroundColor Yellow
        Write-Host $url -ForegroundColor DarkGray

        try {
            [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12
            Invoke-WebRequest -Uri $url -OutFile $Archive -UseBasicParsing
        } catch {
            Fail "Could not download Node.js. First Run needs internet access. $($_.Exception.Message)"
        }
    }

    if (Test-Path $NodeDir) {
        Remove-Item $NodeDir -Recurse -Force
    }

    Expand-Archive -Path $Archive -DestinationPath $ToolsRoot -Force

    if (-not (Test-Path $NodeExe)) {
        Fail "Portable Node.js extraction failed."
    }

    Write-Host "Portable Node.js installed inside .runtime\tools." -ForegroundColor Green
}

function Dependencies-AreHealthy {
    $required = @(
        "node_modules\@wp-playground\cli\package.json",
        "node_modules\@php-wasm\node\package.json",
        "node_modules\@php-wasm\universal\package.json"
    )

    foreach ($file in $required) {
        if (-not (Test-Path (Join-Path $Root $file))) {
            return $false
        }
    }

    $testCode = @"
Promise.all([
 import('@wp-playground/cli'),
 import('@php-wasm/node'),
 import('@php-wasm/universal')
]).then(() => process.exit(0)).catch((e) => {
 console.error(e);
 process.exit(1);
});
"@

    & $NodeExe -e $testCode
    return ($LASTEXITCODE -eq 0)
}

function Install-Dependencies([switch]$Clean) {
    Step "Preparing WordPress Playground dependencies"

    if ($Clean) {
        Write-Host "Repairing dependency tree automatically..." -ForegroundColor Yellow
        if (Test-Path (Join-Path $Root "node_modules")) {
            Remove-Item (Join-Path $Root "node_modules") -Recurse -Force
        }
        if (Test-Path (Join-Path $Root "package-lock.json")) {
            Remove-Item (Join-Path $Root "package-lock.json") -Force
        }
    }

    New-Item -ItemType Directory -Force -Path $NpmCache | Out-Null

    $env:Path = "$NodeDir;$env:Path"
    $env:npm_config_cache = $NpmCache
    $env:npm_config_audit = "false"
    $env:npm_config_fund = "false"
    $env:npm_config_update_notifier = "false"

    & $NpmExe install --no-audit --no-fund
    if ($LASTEXITCODE -ne 0) {
        Fail "Automatic npm dependency installation failed."
    }
}

Step "SakhtYar Flow zero-touch bootstrap"
Ensure-ManagedNode

# Never rely on the machine-wide Node.js version.
$env:Path = "$NodeDir;$env:Path"
Write-Host "Runtime Node.js: $((& $NodeExe --version).Trim())" -ForegroundColor Green

if (-not (Dependencies-AreHealthy)) {
    Install-Dependencies -Clean

    if (-not (Dependencies-AreHealthy)) {
        Step "First repair did not pass verification; retrying from a clean npm cache"
        if (Test-Path $NpmCache) {
            Remove-Item $NpmCache -Recurse -Force
        }
        Install-Dependencies -Clean

        if (-not (Dependencies-AreHealthy)) {
            Fail "Playground dependencies are still unhealthy after automatic repair."
        }
    }
}

Write-Host "Playground dependency verification passed." -ForegroundColor Green

Step "Starting WordPress + SQLite from IntelliJ"

$Runner = Join-Path $Root "scripts\playground-run.mjs"
if (-not (Test-Path $Runner)) {
    Fail "Missing scripts\playground-run.mjs"
}

# The Node process remains owned by IntelliJ. Red Stop terminates it,
# which immediately releases localhost:8080. No daemon/container remains.
& $NodeExe $Runner
exit $LASTEXITCODE