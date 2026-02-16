# Pre-Commit Hook (Portable)

This directory is portable. Copy `git-hooks/` into any git project and run:

```bash
./git-hooks/9-Install-Soft-PreCommit-Hook.sh
```

Install into another project directory:

```bash
./git-hooks/9-Install-Soft-PreCommit-Hook.sh /path/to/other/project
```

What it does:
- Blocks commit when `public` PHP functions are longer than the nudge limit.
- Treats methods with no visibility keyword as `public` (PHP default).
- Does not enforce any limit for `private` or `protected` PHP functions.
- Blocks commit when base templates under `sourceFiles/templates/` exceed the template limit.
- Does not enforce template limits for `sourceFiles/templates/element/` or `sourceFiles/templates/elements/`.

Defaults:
- `public` functions: 45 lines
- base templates: 45 lines

Optional env overrides:

```bash
PRECOMMIT_PUBLIC_FUNCTION_MAX_LINES=40 PRECOMMIT_TEMPLATE_MAX_LINES=50 git commit -m "..."
```

Disable for one commit:

```bash
SOFT_PRECOMMIT_DISABLE=1 git commit -m "..."
```

Or skip all hooks for one commit:

```bash
git commit --no-verify -m "..."
```

Self-test the hook after install:

```bash
./git-hooks/test-hook.sh
```
