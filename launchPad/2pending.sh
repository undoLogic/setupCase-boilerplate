#!/bin/bash
source Z_share.sh

COPY_SRC_TO_ROOT=false

echo "You chose to upload to pending."
USER=$PENDING_USER
URL=$PENDING_URL
GIT_ADDRESS=$PENDING_GIT_ADDRESS
ABSOLUTE_PATH=$PENDING_ABSOLUTE_PATH
COPY_SRC_TO_ROOT=$PENDING_COPY_SRC_TO_ROOT
USE_PAT=$PENDING_USE_PAT

LAUNCH_URL=""

if [ $USE_PAT = true ]
  then
  COMMAND="$USER@$URL cd $ABSOLUTE_PATH && rm -rf * && rm -rf $GITHUB_CURRENT_BRANCH \
&& git clone \"https://\$(php -r 'echo get_cfg_var(\"PAT\");')@$GIT_ADDRESS\" \
--branch $GITHUB_CURRENT_BRANCH --single-branch $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH\
"
  else
   COMMAND="$USER@$URL cd $ABSOLUTE_PATH && rm -rf * && rm -rf $GITHUB_CURRENT_BRANCH \
 && git clone \"$GIT_ADDRESS\" \
 --branch $GITHUB_CURRENT_BRANCH --single-branch $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH\
 "
fi

  # next
if [ $COPY_SRC_TO_ROOT = true ]
  then
    #Rsync files to root
    COMMAND+=" && rsync -av --no-perms --omit-dir-times --fake-super $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ."
    # we are rsyncing to root, so we load the url with firefox
    LAUNCH_URL="$URL/"
  else
    # will NOT rsync to root
    COMMAND+=" "
    # we are NOT rsyncing to root, so we want to load the full path in firefox
    LAUNCH_URL="$URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/"
fi

# for windows
COMMAND+=""
echo "$COMMAND"

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
