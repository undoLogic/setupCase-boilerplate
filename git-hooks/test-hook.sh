#!/usr/bin/env bash
set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
HOOK="$ROOT_DIR/.git/hooks/pre-commit"
TMP_FILE="$ROOT_DIR/.precommit-selftest.php"

if [ ! -x "$HOOK" ]; then
  echo "ERROR: Hook not found or not executable: $HOOK"
  echo "Run: ./git-hooks/9-Install-Soft-PreCommit-Hook.sh"
  exit 1
fi

cleanup() {
  git -C "$ROOT_DIR" reset HEAD "$TMP_FILE" >/dev/null 2>&1 || true
  rm -f "$TMP_FILE"
}
trap cleanup EXIT

run_case() {
  local title="$1"
  local expected="$2"
  local limit="$3"
  local content="$4"

  printf '%s\n' "$content" > "$TMP_FILE"
  git -C "$ROOT_DIR" add "$TMP_FILE"

  set +e
  PRECOMMIT_PUBLIC_FUNCTION_MAX_LINES="$limit" "$HOOK" >/dev/null 2>&1
  local rc=$?
  set -e

  git -C "$ROOT_DIR" reset HEAD "$TMP_FILE" >/dev/null 2>&1

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

run_case "short explicit public should pass" "pass" "10" '<?php
class HookSelfTest {
    public function shortPublic() {
        return true;
    }
}
'

run_case "long explicit public should block" "block" "3" '<?php
class HookSelfTest {
    public function longPublic() {
        // 1
        // 2
        // 3
        // 4
    }
}
'

run_case "private should be ignored" "pass" "3" '<?php
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

run_case "implicit public (no visibility) should block" "block" "3" '<?php
class HookSelfTest {
    function implicitPublic() {
        // 1
        // 2
        // 3
        // 4
    }
}
'

echo "All hook self-tests passed."
