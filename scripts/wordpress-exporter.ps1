param(
    [string]$RepoRoot = "D:\ChatGPT_Projects\SakhtYar\WebSite\sakhtyar-flow"
)

Add-Type -AssemblyName System.Windows.Forms
Add-Type -AssemblyName System.Drawing

$ErrorActionPreference = "Stop"
Set-StrictMode -Version Latest

if (-not (Test-Path $RepoRoot)) {
    [System.Windows.Forms.MessageBox]::Show("Repository not found:`n$RepoRoot","SakhtYar Flow Exporter")
    exit 1
}

function Compress-Folder([string]$SourceDir,[string]$ZipPath,[string]$TopLevelName) {
    $temp = Join-Path $env:TEMP ("syf-export-" + [guid]::NewGuid().ToString("N"))
    $stage = Join-Path $temp $TopLevelName
    New-Item -ItemType Directory -Force -Path $stage | Out-Null
    Copy-Item -Path (Join-Path $SourceDir "*") -Destination $stage -Recurse -Force
    if (Test-Path $ZipPath) { Remove-Item $ZipPath -Force }
    Compress-Archive -Path $stage -DestinationPath $ZipPath -CompressionLevel Optimal
    Remove-Item $temp -Recurse -Force
}

function Run-CmdCapture([string]$Command,[string]$Stdout,[string]$Stderr) {
    $psi = New-Object System.Diagnostics.ProcessStartInfo
    $psi.FileName = "cmd.exe"
    $psi.Arguments = "/d /c $Command"
    $psi.WorkingDirectory = $RepoRoot
    $psi.UseShellExecute = $false
    $psi.CreateNoWindow = $true
    $psi.RedirectStandardOutput = $true
    $psi.RedirectStandardError = $true

    $p = New-Object System.Diagnostics.Process
    $p.StartInfo = $psi
    [void]$p.Start()
    $out = $p.StandardOutput.ReadToEnd()
    $err = $p.StandardError.ReadToEnd()
    $p.WaitForExit()

    [IO.File]::WriteAllText($Stdout,$out,(New-Object Text.UTF8Encoding($false)))
    [IO.File]::WriteAllText($Stderr,$err,(New-Object Text.UTF8Encoding($false)))
    return $p.ExitCode
}

function New-Manifest([string]$Path,[string]$Version,[bool]$Theme,[bool]$Plugins,[bool]$Content,[bool]$Db) {
    $obj = [ordered]@{
        product = "SakhtYar Flow"
        release_version = $Version
        created_at = (Get-Date).ToString("s")
        package_format = "WordPress deployment bundle"
        theme_included = $Theme
        plugins_included = $Plugins
        content_wxr_included = $Content
        database_backup_included = $Db
        notes = @(
            "Theme and plugin packages are ZIP files for direct WordPress upload.",
            "WXR content import does not include site options or attachment binaries.",
            "Database SQL is a safety/full-clone backup and should not be imported over production casually."
        )
    }
    $obj | ConvertTo-Json -Depth 5 | Set-Content -Path $Path -Encoding UTF8
}

$form = New-Object System.Windows.Forms.Form
$form.Text = "SakhtYar Flow - Export to WordPress"
$form.Size = New-Object System.Drawing.Size(640,560)
$form.StartPosition = "CenterScreen"
$form.Font = New-Object System.Drawing.Font("Segoe UI",10)

$title = New-Object System.Windows.Forms.Label
$title.Text = "Export to WordPress"
$title.Font = New-Object System.Drawing.Font("Segoe UI Semibold",18)
$title.Location = New-Object Drawing.Point(24,20)
$title.AutoSize = $true
$form.Controls.Add($title)

$desc = New-Object System.Windows.Forms.Label
$desc.Text = "Choose what should be packaged for the production WordPress host."
$desc.Location = New-Object Drawing.Point(26,58)
$desc.AutoSize = $true
$form.Controls.Add($desc)

$lblVersion = New-Object System.Windows.Forms.Label
$lblVersion.Text = "Version"
$lblVersion.Location = New-Object Drawing.Point(28,98)
$lblVersion.AutoSize = $true
$form.Controls.Add($lblVersion)

$txtVersion = New-Object System.Windows.Forms.TextBox
$txtVersion.Text = "0.3.0"
$txtVersion.Location = New-Object Drawing.Point(130,94)
$txtVersion.Size = New-Object Drawing.Size(180,28)
$form.Controls.Add($txtVersion)

$chkTheme = New-Object System.Windows.Forms.CheckBox
$chkTheme.Text = "Theme ZIP (UI, templates, CSS, JS, theme PHP)"
$chkTheme.Checked = $true
$chkTheme.Location = New-Object Drawing.Point(30,145)
$chkTheme.AutoSize = $true
$form.Controls.Add($chkTheme)

$chkPlugins = New-Object System.Windows.Forms.CheckBox
$chkPlugins.Text = "Plugin ZIPs (site behavior/business functionality under /plugins)"
$chkPlugins.Checked = $true
$chkPlugins.Location = New-Object Drawing.Point(30,180)
$chkPlugins.AutoSize = $true
$form.Controls.Add($chkPlugins)

$chkContent = New-Object System.Windows.Forms.CheckBox
$chkContent.Text = "WordPress content export (WXR XML: posts/pages/categories/menus)"
$chkContent.Checked = $true
$chkContent.Location = New-Object Drawing.Point(30,215)
$chkContent.AutoSize = $true
$form.Controls.Add($chkContent)

$chkDb = New-Object System.Windows.Forms.CheckBox
$chkDb.Text = "Full database SQL backup (advanced / safety only)"
$chkDb.Checked = $false
$chkDb.Location = New-Object Drawing.Point(30,250)
$chkDb.AutoSize = $true
$form.Controls.Add($chkDb)

$note = New-Object System.Windows.Forms.Label
$note.Text = "Recommended production deployment: Theme ZIP + Plugin ZIP(s) + WXR content.`nUse SQL only for full-clone migrations or emergency backup."
$note.ForeColor = [Drawing.Color]::DarkSlateGray
$note.Location = New-Object Drawing.Point(30,292)
$note.Size = New-Object Drawing.Size(560,54)
$form.Controls.Add($note)

$lblOut = New-Object System.Windows.Forms.Label
$lblOut.Text = "Output folder"
$lblOut.Location = New-Object Drawing.Point(28,360)
$lblOut.AutoSize = $true
$form.Controls.Add($lblOut)

$txtOut = New-Object System.Windows.Forms.TextBox
$txtOut.Text = (Join-Path $RepoRoot "dist\releases")
$txtOut.Location = New-Object Drawing.Point(130,356)
$txtOut.Size = New-Object Drawing.Size(420,28)
$form.Controls.Add($txtOut)

$btnBrowse = New-Object System.Windows.Forms.Button
$btnBrowse.Text = "..."
$btnBrowse.Location = New-Object Drawing.Point(558,355)
$btnBrowse.Size = New-Object Drawing.Size(40,30)
$btnBrowse.Add_Click({
    $dlg = New-Object System.Windows.Forms.FolderBrowserDialog
    $dlg.SelectedPath = $txtOut.Text
    if ($dlg.ShowDialog() -eq [Windows.Forms.DialogResult]::OK) { $txtOut.Text = $dlg.SelectedPath }
})
$form.Controls.Add($btnBrowse)

$progress = New-Object System.Windows.Forms.ProgressBar
$progress.Location = New-Object Drawing.Point(30,408)
$progress.Size = New-Object Drawing.Size(568,18)
$progress.Minimum = 0
$progress.Maximum = 100
$form.Controls.Add($progress)

$status = New-Object System.Windows.Forms.Label
$status.Text = "Ready."
$status.Location = New-Object Drawing.Point(30,435)
$status.Size = New-Object Drawing.Size(560,30)
$form.Controls.Add($status)

$btnExport = New-Object System.Windows.Forms.Button
$btnExport.Text = "Export WordPress Package"
$btnExport.Location = New-Object Drawing.Point(360,472)
$btnExport.Size = New-Object Drawing.Size(238,38)
$btnExport.BackColor = [Drawing.Color]::FromArgb(37,99,235)
$btnExport.ForeColor = [Drawing.Color]::White
$btnExport.FlatStyle = "Flat"
$form.Controls.Add($btnExport)

$btnExport.Add_Click({
    try {
        $version = $txtVersion.Text.Trim()
        if ([string]::IsNullOrWhiteSpace($version)) { throw "Version is required." }

        $outRoot = $txtOut.Text.Trim()
        New-Item -ItemType Directory -Force -Path $outRoot | Out-Null

        $timestamp = Get-Date -Format "yyyyMMdd-HHmmss"
        $releaseDir = Join-Path $outRoot ("sakhtyar-flow-wordpress-" + $version + "-" + $timestamp)
        New-Item -ItemType Directory -Force -Path $releaseDir | Out-Null

        $progress.Value = 5
        $status.Text = "Preparing release..."

        if ($chkTheme.Checked) {
            $themeDir = Join-Path $RepoRoot "theme\sakhtyar-flow"
            if (-not (Test-Path $themeDir)) { throw "Theme source not found: $themeDir" }
            $themeZip = Join-Path $releaseDir ("sakhtyar-flow-theme-" + $version + ".zip")
            Compress-Folder $themeDir $themeZip "sakhtyar-flow"
        }

        $progress.Value = 30

        if ($chkPlugins.Checked) {
            $pluginsRoot = Join-Path $RepoRoot "plugins"
            if (Test-Path $pluginsRoot) {
                Get-ChildItem $pluginsRoot -Directory | ForEach-Object {
                    $zip = Join-Path $releaseDir ($_.Name + "-" + $version + ".zip")
                    Compress-Folder $_.FullName $zip $_.Name
                }
            }
        }

        $progress.Value = 50

        if ($chkContent.Checked) {
            $status.Text = "Exporting WordPress content..."
            $xml = Join-Path $releaseDir "content.wordpress.xml"
            $log = Join-Path $releaseDir "content-export.log"
            $cmd = 'docker compose run --rm -T wpcli export --stdout --allow-root'
            $code = Run-CmdCapture $cmd $xml $log
            if ($code -ne 0) {
                throw "Content export failed. See content-export.log"
            }
        }

        $progress.Value = 70

        if ($chkDb.Checked) {
            $status.Text = "Exporting database backup..."
            $sql = Join-Path $releaseDir "database-backup.sql"
            $log = Join-Path $releaseDir "database-export.log"
            $cmd = 'docker compose run --rm -T wpcli db export - --allow-root'
            $code = Run-CmdCapture $cmd $sql $log
            if ($code -ne 0) {
                throw "Database export failed. See database-export.log"
            }
        }

        $progress.Value = 82

        $install = @"
SakhtYar Flow - WordPress Release $version

Recommended installation order on production:

1) BACKUP production WordPress files and database.
2) Theme:
   WordPress Admin -> Appearance -> Themes -> Add New -> Upload Theme
   Upload: sakhtyar-flow-theme-$version.zip
   Activate/update the theme.

3) Plugins (if included):
   WordPress Admin -> Plugins -> Add Plugin -> Upload Plugin
   Upload each plugin ZIP and activate it.

4) Content (if included):
   WordPress Admin -> Tools -> Import -> WordPress
   Import content.wordpress.xml.
   Note: WXR contains posts/pages/terms/comments/attachment records,
   but not WordPress site options or attachment binary files.

5) Database backup:
   database-backup.sql is NOT the normal update mechanism.
   Use it only for full clone/migration or disaster recovery.
   Importing it can overwrite production users, URLs, settings and content.

Production URL:
https://sakhtyarflow.ir
"@
        Set-Content -Path (Join-Path $releaseDir "INSTALL.txt") -Value $install -Encoding UTF8

        New-Manifest (Join-Path $releaseDir "manifest.json") $version $chkTheme.Checked $chkPlugins.Checked $chkContent.Checked $chkDb.Checked

        $bundleZip = Join-Path $outRoot ("sakhtyar-flow-wordpress-" + $version + "-" + $timestamp + ".zip")
        Compress-Archive -Path (Join-Path $releaseDir "*") -DestinationPath $bundleZip -CompressionLevel Optimal -Force

        $progress.Value = 100
        $status.Text = "Export completed."
        [System.Windows.Forms.MessageBox]::Show("Export completed:`n$bundleZip","SakhtYar Flow Exporter",[Windows.Forms.MessageBoxButtons]::OK,[Windows.Forms.MessageBoxIcon]::Information)
        Start-Process explorer.exe "/select,`"$bundleZip`""
    }
    catch {
        $status.Text = "Export failed."
        [System.Windows.Forms.MessageBox]::Show($_.Exception.Message,"Export failed",[Windows.Forms.MessageBoxButtons]::OK,[Windows.Forms.MessageBoxIcon]::Error)
    }
})

[void]$form.ShowDialog()
