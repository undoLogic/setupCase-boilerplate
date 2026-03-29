function Get-CiStatus {
    $statusPath = Join-Path $PSScriptRoot "..\.ci_status.json"
    if (-not (Test-Path $statusPath)) {
        throw "Missing .ci_status.json at repository root"
    }

    try {
        $status = Get-Content $statusPath -Raw | ConvertFrom-Json
    } catch {
        throw "Invalid JSON in .ci_status.json"
    }

    foreach ($field in @('status', 'timestamp', 'commit', 'branch')) {
        if (-not ($status.PSObject.Properties.Name -contains $field) -or [string]::IsNullOrWhiteSpace([string]$status.$field)) {
            throw ".ci_status.json is missing required field '$field'"
        }
    }

    Write-Host "CI status: $($status.status)"
    Write-Host "CI commit: $($status.commit)"
    Write-Host "CI timestamp: $($status.timestamp)"

    return $status
}

$branch = git rev-parse --abbrev-ref HEAD
$localCommit = git rev-parse HEAD
Write-Host "Current GIT branch: $branch"
Write-Host "Current GIT commit: $localCommit"

$configFile = Join-Path $PSScriptRoot "config.json"
if (-not (Test-Path $configFile)) {
    Write-Error "Config file not found: $configFile"
    exit 1
}

$configRoot = Get-Content $configFile -Raw | ConvertFrom-Json
$config = $configRoot.environments

$pendingUser = $config.pending.USER
$pendingUrl = $config.pending.URL
$pendingPath = $config.pending.ABSOLUTE_PATH
$liveUrl = $config.LIVE.URL
$livePath = $config.LIVE.ABSOLUTE_PATH
$postCommands = $config.LIVE.POST_COMMANDS

if ([string]::IsNullOrWhiteSpace($pendingUser) -or [string]::IsNullOrWhiteSpace($pendingUrl) -or [string]::IsNullOrWhiteSpace($pendingPath)) {
    Write-Error "Pending environment is missing USER, URL, or ABSOLUTE_PATH in config.json"
    exit 1
}

if ([string]::IsNullOrWhiteSpace($liveUrl) -or [string]::IsNullOrWhiteSpace($livePath)) {
    Write-Error "LIVE environment is missing URL or ABSOLUTE_PATH in config.json"
    exit 1
}

try {
    $ciStatus = Get-CiStatus
} catch {
    Write-Error $_
    exit 1
}

if ($ciStatus.status -ne 'success') {
    Write-Error "LIVE deploy blocked: CI status must be 'success' for the exact commit being deployed"
    exit 1
}

$pendingCommitCommand = "git -C $pendingPath/$branch rev-parse HEAD"
$pendingCommit = ssh "$pendingUser@$pendingUrl" $pendingCommitCommand
$pendingCommit = ($pendingCommit | Out-String).Trim()

if ([string]::IsNullOrWhiteSpace($pendingCommit)) {
    Write-Error "Unable to determine the commit currently prepared on pending"
    exit 1
}

Write-Host "Pending prepared commit: $pendingCommit"

if ($ciStatus.commit -ne $pendingCommit) {
    Write-Error "LIVE deploy blocked: .ci_status.json commit does not match the commit prepared on pending"
    exit 1
}

$remoteCommand = @"
rsync -av --no-perms --omit-dir-times --fake-super $pendingPath/$branch/sourceFiles/. $livePath/. && cd $livePath && $postCommands
"@

$remoteCommandStripped = $remoteCommand -replace "`r`n", "`n"

Write-Host $remoteCommandStripped
Write-Host "ssh $pendingUser@$liveUrl $remoteCommandStripped"

ssh "$pendingUser@$liveUrl" $remoteCommandStripped

Start-Process "https://$liveUrl"
