# Load configuration file
$configFile = ".\config.json"
if (-not (Test-Path $configFile)) {
    Write-Error "Config file not found: $configFile"
    exit 1
}


$configRoot = Get-Content $configFile -Raw | ConvertFrom-Json
$config = $configRoot.environments

# Testing display
$configJson = Get-Content $configFile -Raw
Write-Host $configJson | Format-List *

# Extract values
$user = $config.pending.USER
$url = $config.LIVE.URL
$branch = if ($config.BRANCH) { $config.BRANCH } else { "master" }
$postCommands = $config.LIVE.POST_COMMANDS

$pendingURL = $config.pending.ABSOLUTE_PATH
$liveURL = $config.LIVE.ABSOLUTE_PATH

# Build the remote command
$remoteCommand = @"
rsync -av --no-perms --omit-dir-times --fake-super
$pendingURL/$branch/sourceFiles/. $liveURL/.
&&
cd $liveURL
&&
$postCommands
"@

# Strip CRLF (Windows -> Linux)
$remoteCommandStripped = $remoteCommand -replace "`r`n", "`n"

Write-Host $remoteCommandStripped

# Execute remotely
Ssh "$user@$url" $remoteCommandStripped



