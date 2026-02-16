#!/usr/bin/env bash
set -euo pipefail

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
TARGET_DIR="${1:-$(cd "$SCRIPT_DIR/.." && pwd)}"

SOURCE_HOOK="$SCRIPT_DIR/pre-commit"
TARGET_HOOK="$TARGET_DIR/.git/hooks/pre-commit"

if [ ! -f "$SOURCE_HOOK" ]; then
  echo "Hook source not found: $SOURCE_HOOK"
  exit 1
fi

if [ ! -d "$TARGET_DIR/.git/hooks" ]; then
  echo "Target is not a git repository with hooks: $TARGET_DIR"
  echo "Usage: $0 [path-to-git-project]"
  exit 1
fi

if [ -f "$TARGET_HOOK" ]; then
  BACKUP="$TARGET_HOOK.backup.$(date +%Y%m%d%H%M%S)"
  cp "$TARGET_HOOK" "$BACKUP"
  echo "Backed up existing hook to: $BACKUP"
fi

cp "$SOURCE_HOOK" "$TARGET_HOOK"
chmod +x "$TARGET_HOOK"

echo "Installed pre-commit hook to: $TARGET_HOOK"
echo "This hook blocks commits when size rules are violated."
echo "- public functions over limit"
echo "- base templates over limit (elements are exempt)"
echo "You can still skip hooks with: git commit --no-verify"
