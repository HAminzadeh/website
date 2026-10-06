param(
    [Parameter(Mandatory = $false)]
    [string]$Version = "0.1.0"
)

$ErrorActionPreference = "Stop"
$Root = Split-Path -Parent $PSScriptRoot
$Theme = Join-Path $Root "theme\sakhtyar-flow"
$Dist = Join-Path $Root "dist"
$Temp = Join-Path $env:TEMP ("sakhtyar-flow-build-" + [guid]::NewGuid().ToString("N"))
$PackageRoot = Join-Path $Temp "sakhtyar-flow"

if (-not (Test-Path $Theme)) {
    throw "Theme source not found: $Theme"
}

New-Item -ItemType Directory -Force -Path $PackageRoot, $Dist | Out-Null
Copy-Item -Path (Join-Path $Theme "*") -Destination $PackageRoot -Recurse -Force

$Zip = Join-Path $Dist "sakhtyar-flow-theme-$Version.zip"
if (Test-Path $Zip) { Remove-Item $Zip -Force }

Compress-Archive -Path $PackageRoot -DestinationPath $Zip -CompressionLevel Optimal
Remove-Item $Temp -Recurse -Force

Write-Host "Built: $Zip" -ForegroundColor Green