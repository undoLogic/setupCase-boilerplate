#!/bin/sh
set -e

TARGET="../mobile-app"

echo "Applying mobile template…"
#rsync -av . $TARGET/.
rsync -av \
  --exclude=8-Import-changes-from-mobile-app.sh \
  --exclude=0-copy-to-app.sh \
  . "$TARGET/"

cd ../mobile-app
npm install

