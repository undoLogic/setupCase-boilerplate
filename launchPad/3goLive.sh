#!/bin/bash
source Z_share.sh

COPY_SRC_TO_ROOT=false

echo "You chose to upload to live."
USER=$LIVE_USER
URL=$LIVE_URL
# GIT_ADDRESS=$LIVE_GIT_ADDRESS
# These vars are used as is
# PENDING_ABSOLUTE_PATH=$PENDING_ABSOLUTE_PATH
# LIVE_ABSOLUTE_PATH=$LIVE_ABSOLUTE_PATH

LAUNCH_URL=""

echo "this will be LIVE"
if [ $COPY_SRC_TO_ROOT = true ]
  then
    COMMAND="$USER@$URL rsync -av --no-perms --omit-dir-times --fake-super $PENDING_ABSOLUTE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""
else
    COMMAND="$USER@$URL rsync -av --no-perms --omit-dir-times --fake-super $PENDING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""
fi
echo "ssh $COMMAND"
LAUNCH_URL=$URL

read -p "Press ENTER to SSH and run COMMAND"

ssh $COMMAND

# Check exit status
if [[ $? -eq 0 ]]; then
  echo -e "\e[32mSSH command executed successfully. - OPENING Browser \e[0m"
  #open firefox new tab with link
  sleep 1 #allow to quickly see success before opening

  # Check if the script is running on macOS
  if [[ "$OSTYPE" == "darwin"* ]]; then
    # Use the correct Firefox path for macOS
    /Applications/Firefox.app/Contents/MacOS/firefox -new-tab "http://$LAUNCH_URL/"
  else
    # If not running on macOS, you can provide a default behavior or display an error message.
    "C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab "$LAUNCH_URL/"
  fi
else
  echo -e "\e[31mSSH command encountered an error.\e[0m"
fi

read -p "Complete - Press enter to close this window"
