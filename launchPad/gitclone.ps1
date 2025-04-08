# Load settings
$settings = Get-Content -Raw -Path "settings.json" | ConvertFrom-Json

############################################################################################### Extract values
$github_use_pat = $settings.TESTING.github_use_pat
$github_repo = $settings.TESTING.github_repo
$github_ssh_key_name = $settings.TESTING.github_ssh_key_name
$copy_src_to_root = $settings.TESTING.copy_src_to_root
$absolute_path = $settings.TESTING.absolute_path

########################################################################################### Get Current Branch
$github_current_branch = git branch --show-current
if ($github_current_branch -eq "master") {
    $github_current_branch = "master"
}

# (Optional) Output
Write-Host "Current Git branch: $github_current_branch"



############################################################################################ Setup connection
if ($github_use_pat -eq $true) {
    $phpCall = '$(php -r ''echo get_cfg_var("PAT");'')'
    $gitUrl = "`"https://$phpCall@github.com/$github_repo.git`""
} else {
    $gitUrl = "`"git@$github_ssh_key_name.github.com:$github_repo.git`""
}

############################################################# Define branch and extract project name from repo

$projectName = $github_repo.Split('/')[-1]
$remotePath = "~/projects/$projectName"

# Remote command to run
$remoteCommand = @"
cd $absolute_path &&
rm -rf $github_current_branch &&
git clone $gitUrl --branch $github_current_branch --single-branch $absolute_path
"@ -replace "`r`n", " "

# SSH command that will be run
$sshCommand = "ssh user@host '$remoteCommand'"



############################################################################################# Copy src to root
if ($copy_src_to_root -eq $true) {
    $remoteCommand += " && rsync -av --no-perms --omit-dir-times --fake-super $absolute_path/$github_current_branch/ ."
}

$ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ."


Write-Host $remoteCommand