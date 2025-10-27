param(
    [string]$envName = "dev"  # default if no argument provided
)

# Load configuration file
$configFile = ".\config.json"
if (-not (Test-Path $configFile)) {
    Write-Error "Config file not found: $configFile"
    exit 1
}

# Read JSON and select environment
$configRoot = Get-Content $configFile -Raw | ConvertFrom-Json
if (-not $configRoot.environments.PSObject.Properties.Name -contains $envName) {
    Write-Error "Environment '$envName' not found in settings.json"
    exit 1
}

$config = $configRoot.environments.$envName

# Extract values
$user = $config.USER
$url = $config.URL
$git = $config.GIT_ADDRESS
$path = $config.ABSOLUTE_PATH
$branch = if ($config.BRANCH) { $config.BRANCH } else { "master" }
$postCommands = $config.POST_COMMANDS
$usePAT = $config.USE_PAT


if ($usePAT -eq $true) {
    # Build the remote command
    $remoteCommand = @"
cd $path &&
rm -rf * &&
rm -rf $branch &&
git clone `"https://`$(php -r 'echo get_cfg_var(\"PAT\");')@$git`" --branch $branch --single-branch $path/$branch &&
rsync -a --info=progress2,stats --no-perms --omit-dir-times --fake-super $path/$branch/sourceFiles/ . &&
$postCommands
"@
} else {
    # Build the remote command
    $remoteCommand = @"
cd $path &&
rm -rf * &&
rm -rf $branch &&
git clone $git --branch $branch --single-branch $path/$branch &&
rsync -a --info=progress2,stats --no-perms --omit-dir-times --fake-super $path/$branch/sourceFiles/ . &&
$postCommands
"@
}






# Strip CRLF (Windows -> Linux)
$remoteCommandStripped = $remoteCommand -replace "`r`n", "`n"

Write-Host "`n--- Environment: $envName ---`n"
Write-Host $remoteCommandStripped

# Execute remotely
ssh "$user@$url" $remoteCommandStripped

# Open browser
Start-Process "https://$url"
