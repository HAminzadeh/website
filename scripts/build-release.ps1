param(
    [string]$RepoRoot = "D:\ChatGPT_Projects\SakhtYar\WebSite\sakhtyar-flow"
)

$ErrorActionPreference = "Stop"
Set-StrictMode -Version Latest

$RepoRoot = [IO.Path]::GetFullPath($RepoRoot)
$ThemeRoot = Join-Path $RepoRoot "theme\sakhtyar-flow"
$PluginRoot = Join-Path $RepoRoot "plugins\sakhtyar-core"
$OutRoot = Join-Path $RepoRoot "dist\releases"

function Read-Version([string]$Path,[string]$Pattern) {
    $text = [IO.File]::ReadAllText($Path)
    $m = [regex]::Match($text,$Pattern,[Text.RegularExpressions.RegexOptions]::Multiline)
    if (-not $m.Success) { throw "Version not found: $Path" }
    return $m.Groups[1].Value.Trim()
}

function Compress-Source([string]$Source,[string]$Top,[string]$Zip) {
    $tmp = Join-Path $env:TEMP ("syf-release-" + [guid]::NewGuid().ToString("N"))
    $stage = Join-Path $tmp $Top
    New-Item -ItemType Directory -Force -Path $stage | Out-Null
    Copy-Item -Path (Join-Path $Source "*") -Destination $stage -Recurse -Force

    Get-ChildItem -LiteralPath $stage -Recurse -Force -ErrorAction SilentlyContinue |
        Where-Object { $_.Name -in @(".DS_Store","Thumbs.db") -or $_.Extension -in @(".log",".tmp",".bak") } |
        Remove-Item -Force -Recurse -ErrorAction SilentlyContinue

    if (Test-Path $Zip) { Remove-Item $Zip -Force }
    Compress-Archive -Path $stage -DestinationPath $Zip -CompressionLevel Optimal
    Remove-Item $tmp -Recurse -Force
}

if (-not (Test-Path (Join-Path $ThemeRoot "style.css"))) { throw "Theme source not found." }
if (-not (Test-Path (Join-Path $PluginRoot "sakhtyar-core.php"))) { throw "Plugin source not found." }

$themeVersion = Read-Version (Join-Path $ThemeRoot "style.css") '^\s*Version:\s*([^\r\n]+)'
$pluginVersion = Read-Version (Join-Path $PluginRoot "sakhtyar-core.php") '^\s*\*\s*Version:\s*([^\r\n]+)'

$stamp = Get-Date -Format "yyyyMMdd-HHmmss"
$releaseDir = Join-Path $OutRoot ("sakhtyar-release-" + $stamp)
New-Item -ItemType Directory -Force -Path $releaseDir | Out-Null

$themeZip = Join-Path $releaseDir ("sakhtyar-flow-theme-" + $themeVersion + ".zip")
$pluginZip = Join-Path $releaseDir ("sakhtyar-core-" + $pluginVersion + ".zip")

Compress-Source $ThemeRoot "sakhtyar-flow" $themeZip
Compress-Source $PluginRoot "sakhtyar-core" $pluginZip

$manifest = [ordered]@{
    product = "SakhtYar Flow"
    created_at = (Get-Date).ToString("s")
    theme_version = $themeVersion
    plugin_version = $pluginVersion
    theme_file = [IO.Path]::GetFileName($themeZip)
    plugin_file = [IO.Path]::GetFileName($pluginZip)
    install_order = @("Backup production","Upload/replace plugin","Upload/replace theme","Verify migrations and smoke-test")
}
$manifest | ConvertTo-Json -Depth 5 | Set-Content -Path (Join-Path $releaseDir "manifest.json") -Encoding UTF8

Write-Host ""
Write-Host "SakhtYar release built successfully" -ForegroundColor Green
Write-Host "Theme : $themeZip"
Write-Host "Plugin: $pluginZip"
Write-Host "Manifest: $(Join-Path $releaseDir 'manifest.json')"
