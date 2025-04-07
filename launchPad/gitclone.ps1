# Load settings
$settings = Get-Content -Raw -Path "settings.json" | ConvertFrom-Json

# Extract values
$usePAT = $settings.github_use_pat
$repo = $settings.github_repo
$sshKeyName = $settings.github_ssh_key_name

# Git URL for remote command
if ($usePAT -eq $true) {
    # NOTE: PHP runs on remote server at execution time
    $gitUrl = "`"https://\$(php -r 'echo get_cfg_var(\"PAT\");')@github.com/$repo.git`""
} else {
    $gitUrl = "`"git@$sshKeyName.github.com:$repo.git`""
}

# Example: use main branch
$branch = "main"
$projectName = $repo.Split('/')[-1]
$remotePath = "~/projects/$projectName"

# Build the full command to run on the server
$remoteCommand = "cd ~/projects && rm -rf $projectName && git clone $gitUrl --branch $branch --single-branch $remotePath"

# Final ssh call to run on server
$sshCommand = "ssh user@host '$remoteCommand'"

# Output to copy or debug
Write-Host "`n--- SSH Command to Run on Remote Server ---"
Write-Host $sshCommand
