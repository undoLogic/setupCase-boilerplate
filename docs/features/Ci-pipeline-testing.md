# FEATURE: SetupCase CI Pipeline (Launchpad Integration)

---

## OVERVIEW

Introduce a lightweight CI system integrated into SetupCase that:

- Runs CakePHP integration tests automatically via GitHub Actions
- Uses **DockerWSL** ONLY for CI (not required in production)
- Outputs a deterministic CI status file into the repository
- Uses a **state-based CI model: pending → success / fail**
- Keeps **manual control over staging and live deployment via LaunchPad_win**
- Integrates directly with existing LaunchPad_win workflow

---

## CORE PRINCIPLES

- Keep system **simple, transparent, and deterministic**
- Maintain **manual control over production deployment**
- Avoid maintaining persistent CI infrastructure (DB, services)
- Ensure every project is initialized via:

/init-web

- CI must be included automatically in every new project
- Use **ephemeral Docker environments (DockerWSL specifically)**
- CI results must be **visible and machine-readable inside repo**
- CI is **validation only**, not deployment
- CI must always reflect **current truth (no stale success allowed)**

---

## LAUNCHPAD MAPPING (CRITICAL)

CI integrates directly into existing LaunchPad_win structure:

### EXISTING LAUNCHPAD STEPS

1. **1-prepare-dev.bat - Setup Test Environment for development (cloud Apache)**
2. **2-prepare-pending.bat - Prepare Staging (Subdomain on production server)**
3. **3-go-LIVE.bat - Go Live (rsync from staging subdomain → live)**

---

### CI ROLE

- CI runs on every GitHub update (commit / pull-request)
- CI does NOT deploy (manual LaunchPad_win workflow only)
- CI produces a **status file (.ci_status.json)**
- LaunchPad_win reads CI result and decides:

| Launchpad Step | CI Dependency |
|----------------|-------------|
| 1-prepare-dev | Show green/red bar based on `.ci_status.json` |
| 2-prepare-pending | Show green/red bar based on `.ci_status.json` |
| 3-go-LIVE | **BLOCKED unless status = success** |

---

## ENVIRONMENTS

### 1. LOCAL (Developer)
- Apache-based (non-Docker)
- Always deploy files for development
- Show CI status (green/red) if available
- 1-prepare-dev.bat

---

### 2. GITHUB ACTIONS (CI)
- Runs on every push / PR
- Uses **DockerWSL configuration**
- Spins up ephemeral DB
- Runs CakePHP tests
- Writes `.ci_status.json` twice:
    - First: `pending`
    - Final: `success` or `fail`

---

### 3. STAGING (Apache Server)
- Receives files
- Reads `.ci_status.json`
- Shows green/red bar
- Does NOT run tests
- 2-prepare-pending.bat

---

### 4. LIVE
- Manual rsync from staging
- BLOCKED unless `status = success`
- Shows green/red bar
- Does NOT run tests
- 3-go-LIVE.bat

---

## CI WORKFLOW (HIGH LEVEL)

1. Developer pushes code to GitHub
2. GitHub Actions triggers workflow

### CI Execution Flow

3. Immediately write .ci_status.json:

```json
{ "status": "pending" }
```

Boot Docker environment (DockerWSL)
Install dependencies
Run CakePHP tests
- Overwrite .ci_status.json:
- SUCCESS → "status": "success"
- FAILURE → "status": "fail"

🚫 NO deployment
🚫 NO staging interaction
🚫 NO live automation

STATUS FILE DESIGN

File Name
.ci_status.json

Location
MUST be at repo root

STATES
Status	Meaning
- pending	CI is running or incomplete
- success	CI passed
- fail	CI failed
STATUS FILE STRUCTURE

Example (Success)
{
  "status": "success",
  "timestamp": "2026-03-29T14:32:10Z",
  "commit": "abc123",
  "branch": "main",
  "environment": "github_actions_docker_wsl"
}

Example (Fail)
{
  "status": "fail",
  "timestamp": "2026-03-29T14:32:10Z",
  "commit": "abc123",
  "branch": "main",
  "environment": "github_actions_docker_wsl"
}

Example (Pending)
{
  "status": "pending",
  "timestamp": "2026-03-29T14:30:00Z",
  "commit": "abc123",
  "branch": "main"
}

LAUNCHPAD_win DEPLOYMENT RULE
HARD RULE

LaunchPad_win 3-go-LIVE.bat must:

Read .ci_status.json
ONLY proceed if:
status == success
WINDOWS (.bat) IMPLEMENTATION
```batch
@echo off

if not exist .ci_status.json (
    echo ERROR: CI status file not found
    exit /b 1
)

set STATUS=

for /f "delims=" %%i in ('type .ci_status.json ^| findstr "status"') do set LINE=%%i

echo %LINE% | findstr "success" >nul
if %errorlevel%==0 (
    echo CI PASSED — proceed to go live
    exit /b 0
)

echo ERROR: CI NOT SUCCESS (pending or fail) — BLOCK DEPLOY
exit /b 1
```

GITHUB ACTIONS WORKFLOW
Location
.github/workflows/ci.yml
```yaml
REQUIRED PERMISSIONS
permissions:
  contents: write
TRIGGER (NO LOOP)
on:
  push:
    branches: [ "*" ]
    paths-ignore:
      - ".ci_status.json"
  pull_request:
WORKFLOW TEMPLATE
name: SetupCase CI

permissions:
  contents: write

on:
  push:
    branches: [ "*" ]
    paths-ignore:
      - ".ci_status.json"
  pull_request:

jobs:
  test:
    runs-on: ubuntu-latest

    steps:
      - name: Checkout repo
        uses: actions/checkout@v4

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.1'

      - name: Write CI status = pending
        run: |
          TIMESTAMP=$(date -u +"%Y-%m-%dT%H:%M:%SZ")

          cat <<EOF > .ci_status.json
          {
            "status": "pending",
            "timestamp": "$TIMESTAMP",
            "commit": "${{ github.sha }}",
            "branch": "${{ github.ref_name }}"
          }
          EOF

      - name: Commit pending status
        run: |
          git config user.name "ci-bot"
          git config user.email "ci@undologic.com"
          git add .ci_status.json
          git commit -m "CI status: pending" || echo "No changes"
          git push

      - name: Install dependencies
        run: composer install --no-progress --prefer-dist

      - name: Start DockerWSL environment
        run: docker compose -f DockerWSL/docker-compose.yml up -d

      - name: Wait for DB
        run: sleep 10

      - name: Run CakePHP tests
        run: vendor/bin/phpunit

      - name: Write final CI status
        if: always()
        run: |
          TIMESTAMP=$(date -u +"%Y-%m-%dT%H:%M:%SZ")

          if [ "${{ job.status }}" = "success" ]; then
            RESULT="success"
          else
            RESULT="fail"
          fi

          cat <<EOF > .ci_status.json
          {
            "status": "$RESULT",
            "timestamp": "$TIMESTAMP",
            "commit": "${{ github.sha }}",
            "branch": "${{ github.ref_name }}"
          }
          EOF

      - name: Commit final CI status
        if: always()
        run: |
          git config user.name "ci-bot"
          git config user.email "ci@undologic.com"
          git add .ci_status.json
          git commit -m "CI status: final" || echo "No changes"
          git push
```

INIT-web INTEGRATION (SETUPCASE)
LOCATION
/init-web
NEW INIT STEP
CI_SETUP

RESPONSIBILITIES
Copy .github/workflows/ci.yml
Ensure DockerWSL config exists
Add baseline CakePHP test
Configure PHPUnit
Ensure CI runs immediately after first push
DEFAULT BASE TEST (MANDATORY)
STRATEGY
Test FAILS by default
Forces developer to configure CI properly

EXAMPLE
```php
public function testSetupCaseBaseline()
{
    $this->fail('CI not configured yet');
}
```

EXPECTED FLOW
New project initialized via /init-web
First push → CI runs → FAILS
Developer configures DB/tests
Replace baseline test
CI passes → system is active

OPTIONAL FUTURE ENHANCEMENTS
1. Test Metrics
"tests": {
  "total": 42,
  "passed": 42,
  "failed": 0
}
2. LaunchPad_win UI
Show:
✔ PASS
❌ FAIL
⏳ PENDING
3. Artifact Logs
Store full PHPUnit output
FINAL ARCHITECTURE
GitHub = CI engine
DockerWSL = test runtime
Repo = CI truth (.ci_status.json)
LaunchPad_win = deployment control
Apache = runtime environment