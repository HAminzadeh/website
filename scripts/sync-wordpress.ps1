$ErrorActionPreference = "Stop"
$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

function RunNative([scriptblock]$Command) {
    $old = $ErrorActionPreference
    try {
        $ErrorActionPreference = "Continue"
        & $Command 2>&1 | Out-Host
        return [int]$LASTEXITCODE
    } finally {
        $ErrorActionPreference = $old
    }
}

Write-Host "Synchronizing IntelliJ project source -> WordPress..." -ForegroundColor Cyan

$theme = RunNative { docker compose run --rm wpcli theme activate sakhtyar-flow --allow-root }
if ($theme -ne 0) { throw "Theme activation failed." }

$plugin = RunNative { docker compose run --rm wpcli plugin activate sakhtyar-core --allow-root }
if ($plugin -ne 0) { throw "sakhtyar-core activation failed." }

$sync = RunNative {
    docker compose run --rm wpcli eval-file /var/www/html/wp-content/sakhtyar-content/data/sync-wordpress.php --allow-root
}
if ($sync -ne 0) { throw "Content synchronization failed." }

RunNative { docker compose run --rm wpcli rewrite flush --hard --allow-root } | Out-Null

Write-Host "Source and WordPress are synchronized." -ForegroundColor Green