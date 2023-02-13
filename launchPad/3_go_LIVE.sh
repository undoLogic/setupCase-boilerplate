#!/bin/sh

source Z_share.sh
COMMAND=$STAGING_USER@$STAGING_URL "rsync -av --omit-dir-times --no-perms $STAGING_ABSOLUTE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""

echo "ssh $COMMAND"

echo "LIVE URL:" $LIVE_URL

read -p "Press enter to go LIVE"

ssh $COMMAND

"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $LIVE_URL

read -p "LIVE - Press enter to close"