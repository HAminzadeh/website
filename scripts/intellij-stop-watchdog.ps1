param(
    [Parameter(Mandatory=$true)][int]$ParentPid,
    [Parameter(Mandatory=$true)][string]$RepoRoot
)

$ErrorActionPreference = "SilentlyContinue"
Set-Location $RepoRoot

while (Get-Process -Id $ParentPid -ErrorAction SilentlyContinue) {
    Start-Sleep -Milliseconds 700
}

# IntelliJ stopped/killed the run process: force the local project down.
docker compose down --remove-orphans *> $null