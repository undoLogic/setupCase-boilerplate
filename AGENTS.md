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
- Keep public functions short enough to fit on one screen.
- If a public function gets long, split logic into private helper functions.
- For helper-to-public data flow, set class properties in private functions and read them in the public function.
- Do not rely on returning values from private helper functions for this pattern.
- Private functions may be longer than one screen when needed.
- Keep each template file short enough to fit on one screen.
- If a template gets long, extract parts into elements (elements may be longer than one screen).
- Name private helper functions similar to their related public function.
- Name template elements similar to the public function/action they support.

## File Editing Rules
- Do not modify generated or vendor files unless explicitly requested.
- Prefer editing source files under `sourceFiles/`.
- Keep ASCII unless the file already requires Unicode.

## Testing and Verification
- For template/view changes, verify rendered markup is valid and consistent.
- For controller/model changes, run available project tests when possible.
- If tests cannot be run, clearly state what was verified manually.

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
