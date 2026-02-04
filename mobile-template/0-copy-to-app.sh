#!/bin/sh
set -e

TARGET="../mobile-app"

echo "Applying mobile template…"
rsync -av . $TARGET/.

cd ../mobile-app
npm install

