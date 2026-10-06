$ErrorActionPreference = "Stop"
$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

Write-Host "Refreshing local WordPress state..." -ForegroundColor Cyan

# Ensure stack is running.
docker compose up -d db wordpress phpmyadmin | Out-Null

# Flush rewrite rules and caches after structural/theme changes.
docker compose run --rm wpcli rewrite flush --hard --allow-root | Out-Null

# Re-activate theme so after_switch_theme migrations/bootstrap can run when needed.
docker compose run --rm wpcli theme activate sakhtyar-flow --allow-root | Out-Null

Write-Host "Local WordPress refreshed." -ForegroundColor Green
Write-Host "Open/refresh: http://localhost:8080"