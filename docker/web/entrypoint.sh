#!/usr/bin/env sh
set -eu

# You can override these with env vars if needed
APP_DIR="${APP_DIR:-/var/www/vhosts/website.com/www/sourceFiles}"
SEED_DIR="${SEED_DIR:-/sourceFiles}"   # <- Windows bind mount comes here
FORCE_SEED="${FORCE_SEED:-0}"

[ "$FORCE_SEED" = "1" ] && rm -f "$APP_DIR/.initialized" || true

if [ -d "$SEED_DIR" ] && [ ! -f "$APP_DIR/.initialized" ]; then
  echo "Seeding from $SEED_DIR -> $APP_DIR ..."
  mkdir -p "$APP_DIR"
  # copy INCLUDING dotfiles
  # (the trailing '/.' means copy contents, not the folder itself)
  cp -a "$SEED_DIR"/. "$APP_DIR"/
  touch "$APP_DIR/.initialized"
else
  echo "Seed step skipped (no seed dir or already initialized)."
fi

exec "$@"
