#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
HOOK="$ROOT_DIR/.git/hooks/pre-commit"
TMP_PHP_FILE_REL=".precommit-selftest.php"
TMP_TEMPLATE_FILE_REL="sourceFiles/templates/.precommit-selftest-template.php"
TMP_ELEMENT_FILE_REL="sourceFiles/templates/element/.precommit-selftest-element.php"

if [ ! -x "$HOOK" ]; then
  echo "ERROR: Hook not found or not executable: $HOOK"
  echo "Run: ./git-hooks/9-Install-Soft-PreCommit-Hook.sh"
  exit 1
fi

if [ -n "$(git -C "$ROOT_DIR" diff --cached --name-only)" ]; then
  echo "ERROR: Staged changes detected."
  echo "Please unstage current changes before running ./git-hooks/test-hook.sh"
  exit 1
fi

cleanup() {
  git -C "$ROOT_DIR" reset HEAD "$TMP_PHP_FILE_REL" "$TMP_TEMPLATE_FILE_REL" "$TMP_ELEMENT_FILE_REL" >/dev/null 2>&1 || true
  rm -f "$ROOT_DIR/$TMP_PHP_FILE_REL" "$ROOT_DIR/$TMP_TEMPLATE_FILE_REL" "$ROOT_DIR/$TMP_ELEMENT_FILE_REL"
}
trap cleanup EXIT

run_case() {
  local title="$1"
  local expected="$2"
  local public_limit="$3"
  local template_limit="$4"
  local relpath="$5"
  local content="$6"

  local fullpath="$ROOT_DIR/$relpath"
  mkdir -p "$(dirname "$fullpath")"
  printf '%s\n' "$content" > "$fullpath"
  git -C "$ROOT_DIR" add "$relpath"

  set +e
  PRECOMMIT_PUBLIC_FUNCTION_MAX_LINES="$public_limit" PRECOMMIT_TEMPLATE_MAX_LINES="$template_limit" "$HOOK" >/dev/null 2>&1
  local rc=$?
  set -e

  git -C "$ROOT_DIR" reset HEAD "$relpath" >/dev/null 2>&1
  rm -f "$fullpath"

  if [ "$expected" = "pass" ] && [ "$rc" -eq 0 ]; then
    echo "PASS: $title"
    return
  fi

  if [ "$expected" = "block" ] && [ "$rc" -ne 0 ]; then
    echo "PASS: $title"
    return
  fi

  echo "FAIL: $title (expected $expected, got exit=$rc)"
  exit 1
}

run_case "short explicit public should pass" "pass" "10" "10" "$TMP_PHP_FILE_REL" '<?php
class HookSelfTest {
    public function shortPublic() {
        return true;
    }
}
'

run_case "long explicit public should block" "block" "3" "99" "$TMP_PHP_FILE_REL" '<?php
class HookSelfTest {
    public function longPublic() {
        // 1
        // 2
        // 3
        // 4
    }
}
'

run_case "private should be ignored" "pass" "3" "99" "$TMP_PHP_FILE_REL" '<?php
class HookSelfTest {
    private function longPrivate() {
        // 1
        // 2
        // 3
        // 4
        // 5
    }
}
'

run_case "implicit public (no visibility) should block" "block" "3" "99" "$TMP_PHP_FILE_REL" '<?php
class HookSelfTest {
    function implicitPublic() {
        // 1
        // 2
        // 3
        // 4
    }
}
'

run_case "base template should block when too long" "block" "99" "3" "$TMP_TEMPLATE_FILE_REL" '<?php
// 1
// 2
// 3
// 4
// 5
'

run_case "element template should be ignored" "pass" "99" "3" "$TMP_ELEMENT_FILE_REL" '<?php
// 1
// 2
// 3
// 4
// 5
// 6
'

echo "All hook self-tests passed."
