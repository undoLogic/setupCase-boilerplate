# AGENTS.md

## Purpose
Repository-specific instructions for coding, reviews, and collaboration.

## Tech Stack
- PHP (CakePHP)
- Frontend templates in `sourceFiles/templates`

## Coding Rules
- Keep changes small and targeted to the requested task.
- Preserve existing naming/style in touched files.
- Avoid unrelated refactors unless explicitly requested.
- Prefer readable code over clever shortcuts.
- Add comments only when logic is non-obvious.
- Any public method in a table must return a response array with at least:
    - `STATUS` (e.g., `200`)
    - `MSG` (short description of what happened)
    - plus any additional needed data.
- Private functions may return simple values without arrays.
- Keep public functions short enough to fit on one screen (less then 35 lines).
- If a public function gets long, split logic into private helper functions.
- Name private helper functions similar to their related public function prepend public function name then underscore private function name).
- For helper-to-public data flow, set class properties in private functions and read them in the public function.
- Do not rely on returning values from private helper functions for this pattern.
- Private functions may be longer than one screen when needed (no limit).
- Keep each template file short enough to fit on one screen.
- Always add the entire bootstrap structure to this template file
- If a template gets long, extract parts into elements, but keep the bootstrap overview
- For base templates under `sourceFiles/templates/`, keep a short Bootstrap overview shell (row/col/card structure only).
- Move detailed UI/content blocks into elements and render them from the base template.
- Keep base templates under one screen whenever possible; place complexity in elements.
- Elements may be longer than one screen (no limit).
- Name template elements similar to the public function/action they support.

## File Editing Rules
- Do not modify generated or vendor files unless explicitly requested.
- Treat anything under `sourceFiles/webroot/modules` as vendor/original layout assets. Do not edit these files.
- For layout/script/style overrides, place changes under `sourceFiles/webroot/js` or `sourceFiles/webroot/css` instead.
- Prefer editing source files under `sourceFiles/`.
- Keep ASCII unless the file already requires Unicode.

## Testing and Verification
- For template/view changes, verify rendered markup is valid and consistent.
- For controller/model changes, run available project tests when possible.
- If tests cannot be run, clearly state what was verified manually.

## Linting and Cleanup Workflow
- Run linting/formatting cleanup only when nothing is staged.
- Pre-check before cleanup: `git diff --cached --quiet`.
- If staged changes exist, do not run broad cleanup in the same commit.
- Keep cleanup in a dedicated commit separate from functional changes.
- When doing a basic manual lint pass, normalize method declaration indentation first.
- Top-level class methods must use one class-level indent consistently (no extra leading indentation).
- Prefer minimal indentation-only fixes when the request is about formatting consistency.
- Cleanup commit message should clearly indicate structure/format-only scope.
- Do not mix behavior changes with cleanup in the same commit.

## Pre-Commit Hook Policy
- Pre-commit blocks when `public` PHP functions exceed one screen (default limit: `45` lines).
- Methods without explicit visibility are treated as `public`.
- `private` and `protected` function lengths are not limited by this hook.
- Pre-commit blocks when base templates under `sourceFiles/templates/` exceed one screen (default limit: `45` lines).
- Template elements under `sourceFiles/templates/element/` and `sourceFiles/templates/elements/` are exempt from template length limits.
- Override function limit per commit with `PRECOMMIT_PUBLIC_FUNCTION_MAX_LINES=<n>`.
- Override template limit per commit with `PRECOMMIT_TEMPLATE_MAX_LINES=<n>`.
- Bypass this hook logic for one commit with `SOFT_PRECOMMIT_DISABLE=1`.
- Skip all hooks for one commit with `git commit --no-verify`.

## Git and Change Hygiene
- Never revert user changes that are unrelated to the task.
- Keep diffs minimal.
- Make one logical change per commit when asked to commit.

## Review Priorities
When asked for a review, prioritize:
1. Bugs and regressions
2. Security and data handling risks
3. Missing validation/error handling
4. Test gaps

## Communication Preferences
- Be concise and direct.
- Include file paths for all changes.
- State assumptions and blockers clearly.

## Local Conventions
- Put reusable template snippets in `sourceFiles/templates/element/` when appropriate.
- Keep `CodeBlocks` examples simple and copy/paste-friendly.

## Notes For Future Updates
Add project-specific rules here over time (formatters, linters, test commands, deployment constraints).
