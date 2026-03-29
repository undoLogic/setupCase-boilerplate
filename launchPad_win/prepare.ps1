param(
    [string]$envName = "dev"
)

function Get-CiStatus {
    $statusPath = Join-Path $PSScriptRoot "..\.ci_status.json"
    if (-not (Test-Path $statusPath)) {
        Write-Host "CI status: missing (.ci_status.json not found)"
        return $null
    }

    try {
        $status = Get-Content $statusPath -Raw | ConvertFrom-Json
    } catch {
        Write-Host "CI status: invalid JSON in .ci_status.json"
        return $null
    }

    $statusValue = if ($status.status) { $status.status } else { "missing" }
    $commitValue = if ($status.commit) { $status.commit } else { "missing" }
    $timestampValue = if ($status.timestamp) { $status.timestamp } else { "missing" }

    Write-Host "CI status: $statusValue"
    Write-Host "CI commit: $commitValue"
    Write-Host "CI timestamp: $timestampValue"

    return $status
}

$branch = git rev-parse --abbrev-ref HEAD
$commit = git rev-parse HEAD
Write-Host "Current GIT branch: $branch"
Write-Host "Current GIT commit: $commit"

Get-CiStatus | Out-Null

$configFile = Join-Path $PSScriptRoot "config.json"
if (-not (Test-Path $configFile)) {
    Write-Error "Config file not found: $configFile"
    exit 1
}

$configRoot = Get-Content $configFile -Raw | ConvertFrom-Json
if (-not ($configRoot.environments.PSObject.Properties.Name -contains $envName)) {
    Write-Error "Environment '$envName' not found in config.json"
    exit 1
}

$config = $configRoot.environments.$envName
$user = $config.USER
$url = $config.URL
$git = $config.GIT_ADDRESS
$path = $config.ABSOLUTE_PATH
$postCommands = $config.POST_COMMANDS
$usePAT = $config.USE_PAT
$copySrcToRoot = $config.COPY_SRC_TO_ROOT

if ([string]::IsNullOrWhiteSpace($user) -or [string]::IsNullOrWhiteSpace($url) -or [string]::IsNullOrWhiteSpace($path)) {
    Write-Error "Environment '$envName' is missing USER, URL, or ABSOLUTE_PATH in config.json"
    exit 1
}

$syncCommand = if ($copySrcToRoot -eq $false) {
    "rsync -a --info=progress2,stats --no-perms --omit-dir-times --fake-super $path/$branch/ ./"
} else {
    "rsync -a --info=progress2,stats --no-perms --omit-dir-times --fake-super $path/$branch/sourceFiles/ ./"
}

if ($usePAT -eq $true) {
    $cloneCommand = "git clone `"https://`$(php -r 'echo get_cfg_var(\"PAT\");')@$git`" --branch $branch --single-branch $path/$branch"
} else {
    if ([string]::IsNullOrWhiteSpace($git)) {
        Write-Error "Environment '$envName' is missing GIT_ADDRESS in config.json"
        exit 1
    }
    $cloneCommand = "git clone $git --branch $branch --single-branch $path/$branch"
}

$remoteCommand = @"
cd $path &&
rm -rf * &&
rm -rf $branch &&
$cloneCommand &&
$syncCommand &&
$postCommands
"@

$remoteCommandStripped = $remoteCommand -replace "`r`n", "`n"

Write-Host "`n--- Environment: $envName ---`n"
Write-Host $remoteCommandStripped

ssh "$user@$url" $remoteCommandStripped

Start-Process "https://$url"
