# Feature: CI Pipeline Testing

## Summary

Add a lightweight CI validation pipeline to SetupCase. GitHub Actions runs CakePHP tests inside DockerWSL, writes a repository status file at `.ci_status.json`, and LaunchPad_win reads that file to display CI state and block live deployment unless the exact commit being deployed has passed.

## Goals

- Run CakePHP tests automatically on GitHub pushes and pull requests.
- Keep CI infrastructure ephemeral and simple.
- Use DockerWSL only for CI, not for staging or production runtime.
- Expose CI result inside the repository through a deterministic JSON file.
- Preserve manual deployment control through LaunchPad_win.
- Prevent stale CI success from being used for a newer untested commit.

## Non-Goals

- No automatic deployment from GitHub Actions.
- No persistent CI service or separate status database.
- No Docker runtime requirement for Apache staging or live environments.
- No change to the manual LaunchPad_win deployment sequence.
- No local test execution triggered by `/init-web`.

## LaunchPad Mapping

Current LaunchPad_win flow:

1. `1-prepare-dev.bat`
2. `2-prepare-pending.bat`
3. `3-go-LIVE.bat`

CI integration rules:

- `1-prepare-dev.bat` shows the current CI state if `.ci_status.json` exists.
- `2-prepare-pending.bat` shows the current CI state if `.ci_status.json` exists.
- `3-go-LIVE.bat` must stop unless the status file reports `success` for the exact commit being deployed.

## High-Level Flow

1. A project is initialized with `/init-web`.
2. `/init-web` creates the CI workflow files, baseline test scaffolding, and supporting config.
3. `/init-web` does not run tests locally. It only prepares the repository so GitHub can run CI later.
4. A developer pushes code to GitHub.
5. GitHub Actions starts the CI workflow.
6. The workflow writes `.ci_status.json` with `status = pending`.
7. The workflow installs dependencies, starts DockerWSL services, and runs CakePHP tests.
8. The workflow overwrites `.ci_status.json` with `status = success` or `status = fail`.
9. LaunchPad_win reads `.ci_status.json` and enforces deployment rules.

## Environments

### Local Developer

- Apache-based, non-Docker runtime.
- Can show CI status if `.ci_status.json` exists locally.
- Uses `1-prepare-dev.bat`.

### GitHub Actions CI

- Triggered on push and pull request.
- Uses DockerWSL for the test runtime.
- Creates an ephemeral database/service stack.
- Runs CakePHP tests only.
- Does not deploy.

### Staging

- Apache-based runtime.
- Receives files and reads `.ci_status.json`.
- Does not run CI tests.
- Uses `2-prepare-pending.bat`.

### Live

- Apache-based runtime.
- Receives files from the manual LaunchPad flow.
- Does not run CI tests.
- Uses `3-go-LIVE.bat`.

## Status File Contract

Path:

`/.ci_status.json`

Rules:

- The file must live at the repository root.
- The file is overwritten on each CI run.
- The file must describe the current CI state for one commit.
- Invalid or missing JSON must be treated as a failed CI state by LaunchPad_win.

Allowed states:

- `pending`
- `success`
- `fail`

Required fields:

- `status`
- `timestamp`
- `commit`
- `branch`

Optional fields:

- `environment`
- `workflow`
- `run_url`

Example:

```json
{
  "status": "success",
  "timestamp": "2026-03-29T14:32:10Z",
  "commit": "abc123def456",
  "branch": "main",
  "environment": "github_actions_docker_wsl"
}
```

### Anti-Stale Rule

LaunchPad_win must not trust a green status unless:

- `status == "success"`
- `.ci_status.json.commit` matches the exact commit being deployed

If the commit does not match, LaunchPad_win must treat the result as not deployable.

## GitHub Actions Workflow

Location:

`.github/workflows/ci.yml`

Required behavior:

- Trigger on `push` and `pull_request`.
- Ignore `.ci_status.json` changes on `push` to avoid self-trigger loops.
- Use `permissions: contents: write` because the workflow writes the status file back to the branch.
- Write `pending` at the start of the job.
- Always write the final `success` or `fail` result, even if a step fails.
- Use DockerWSL services for the test runtime.
- Run CakePHP tests through PHPUnit.
- Never deploy or call LaunchPad scripts.

Suggested workflow outline:

1. Checkout repository.
2. Set up PHP and Composer dependencies.
3. Write `.ci_status.json` with `pending`.
4. Commit and push the pending status.
5. Start DockerWSL services.
6. Wait for the database/service stack.
7. Run `vendor/bin/phpunit`.
8. Write `.ci_status.json` with `success` or `fail`.
9. Commit and push the final status.

## `/init-web` Responsibilities

`/init-web` must scaffold CI for every new project.

It prepares the repository so GitHub Actions can run tests after the first push. `/init-web` itself does not execute the test suite.

### Dedicated Init Step

`/init-web` must add a dedicated installer file named `9-install-CodeBlocks_citesting.php`.

Purpose:

- Centralize the CI bootstrap logic in one place.
- Generate or copy the GitHub Actions YAML file and related CI support files.
- Keep CI setup adjustable in the future without rewriting unrelated `/init-web` steps.
- Make future process changes easier when CI requirements evolve.

This file is responsible for the scripts that add or update the GitHub workflow, CI config, baseline test scaffolding, and any related setup files needed for CI enablement.

Required outputs:

- `9-install-CodeBlocks_citesting.php`
- `.github/workflows/ci.yml`
- DockerWSL CI configuration
- PHPUnit configuration
- A baseline CakePHP test
- Any bootstrap needed for the baseline test to execute

### Baseline Test Rule

The generated baseline test must fail by default so CI is visible immediately after first push and forces the developer to finish project-specific setup.

Example:

```php
public function testSetupCaseBaseline()
{
    $this->fail('CI not configured yet');
}
```

Expected first-run behavior:

1. Project is created with `/init-web`.
2. `/init-web` writes `9-install-CodeBlocks_citesting.php`, which generates or installs the GitHub workflow and supporting CI files.
3. No tests run during initialization.
4. First push starts GitHub Actions CI.
5. CI fails because the baseline test fails.
6. Developer configures the project test setup.
7. Developer replaces or updates the baseline test.
8. CI passes and the project becomes deployable.

## LaunchPad_win Rules

### Display Rules

`1-prepare-dev.bat` and `2-prepare-pending.bat` should display:

- current CI state
- commit from `.ci_status.json`
- timestamp from `.ci_status.json`

### Deployment Gate

`3-go-LIVE.bat` must block when any of the following is true:

- `.ci_status.json` is missing
- `.ci_status.json` is invalid JSON
- `status` is `pending`
- `status` is `fail`
- `commit` does not match the commit being deployed

`3-go-LIVE.bat` may proceed only when:

- `status` is `success`
- `commit` matches the commit being deployed

## Constraints and Scope Notes

- Version 1 targets normal branch pushes and same-repository pull requests.
- Fork-based pull requests may run tests, but writing `.ci_status.json` back to the source branch is not guaranteed by GitHub permissions.
- CI is the validation layer only. Deployment remains manual and local to LaunchPad_win.

## Acceptance Criteria

- A new project created by `/init-web` contains `9-install-CodeBlocks_citesting.php`, CI workflow scaffolding, and a failing baseline test.
- `/init-web` creates the GitHub workflow files through `9-install-CodeBlocks_citesting.php` but does not run tests itself.
- A push to GitHub starts the CI workflow automatically.
- The workflow writes `.ci_status.json` with `pending` before tests start.
- A passing test run updates `.ci_status.json` to `success`.
- A failing test run updates `.ci_status.json` to `fail`.
- The status file contains the commit hash and branch name for the tested revision.
- LaunchPad_win displays the CI state in dev and pending flows.
- LaunchPad_win blocks `3-go-LIVE.bat` unless the current commit has `success`.
- No part of the CI workflow deploys code.
- DockerWSL is required only for CI execution, not for Apache staging or live runtime.

## Implementation Order

1. Add GitHub Actions workflow and status file handling.
2. Add `/init-web` CI scaffolding through `9-install-CodeBlocks_citesting.php` and include the failing baseline test.
3. Add LaunchPad_win status display and live-deploy gate.
4. Validate the full flow with one failing run and one passing run.
