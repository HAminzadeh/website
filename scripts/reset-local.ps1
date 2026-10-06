$ErrorActionPreference = "Stop"
$Root = Split-Path -Parent $PSScriptRoot
Set-Location $Root

Write-Host "WARNING: This removes the LOCAL WordPress database and files." -ForegroundColor Yellow
$confirmation = Read-Host "Type RESET to continue"
if ($confirmation -ne "RESET") {
    Write-Host "Cancelled."
    exit 0
}

docker compose down -v
& "$PSScriptRoot\start-local.ps1"