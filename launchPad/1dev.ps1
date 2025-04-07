# Load settings
$settings = Get-Content -Raw -Path "settings.json" | ConvertFrom-Json

# Load environment variables
$GITHUB_CURRENT_BRANCH = $env:GITHUB_CURRENT_BRANCH

# Shortcut variables
$URL = $settings.TESTING_URL
$USER = $settings.TESTING_USER
$GIT_ADDRESS = $settings.TESTING_GIT_ADDRESS
$ABSOLUTE_PATH = $settings.TESTING_ABSOLUTE_PATH
$USE_PAT = $settings.TESTING_USE_PAT
$COPY_TO_ROOT = $settings.TESTING_COPY_SRC_TO_ROOT
$SRC_PATH = $settings.SRC_FILES_RELATIVE_PATH

# Git clone command
if ($USE_PAT -eq $true) {
    $PAT = php -r 'echo get_cfg_var("PAT");'
    $cloneCommand = "git clone `"https://$PAT@$GIT_ADDRESS`" --branch $GITHUB_CURRENT_BRANCH --single-branch $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH"
} else {
    $cloneCommand = "git clone `"$GIT_ADDRESS`" --branch $GITHUB_CURRENT_BRANCH --single-branch $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH"
}

# Start building SSH command
$sshCommand = "cd $ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH && $cloneCommand"

# Optional rsync to root
if ($COPY_TO_ROOT -eq $true) {
    $sshCommand += " && rsync -av --no-perms --omit-dir-times --fake-super $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_PATH/ ."
    $LAUNCH_URL = "http://$URL/"
} else {
    $LAUNCH_URL = "http://$URL/$GITHUB_CURRENT_BRANCH/$SRC_PATH/"
}

# Wrap full remote command for SSH
$COMMAND = "ssh $USER@$URL '$sshCommand'"

# Output command and launch URL
Write-Host "Remote Command:"
Write-Host $COMMAND
Write-Host "`nLaunch URL:"
Write-Host $LAUNCH_URL

# Optional: Launch in Firefox (Windows only)
# Start-Process "firefox" $LAUNCH_URL
