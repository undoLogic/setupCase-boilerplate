#!/bin/sh
source Z_share.sh

if [ $TESTING2_COPY_SRC_TO_ROOT = true ]
then
  # WILL rsync the branch to the root (required for authentication / login)
  COMMAND="$TESTING2_USER@$TESTING2_URL cd $TESTING2_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone $TESTING2_GIT_ADDRESS --branch $GITHUB_CURRENT_BRANCH --single-branch $TESTING2_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  && rsync -av $TESTING2_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ." && echo ""
else
  # WILL rsync the branch to the root (required for authentication / login)
  COMMAND="$TESTING2_USER@$TESTING2_URL cd $TESTING2_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone $TESTING2_GIT_ADDRESS --branch $GITHUB_CURRENT_BRANCH --single-branch $TESTING2_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  " && echo ""
fi

echo $COMMAND

echo " "
read -p "Press enter to update TESTING2 server"

ssh $COMMAND
#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
#"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING2_URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING2_URL/

read -p "Uploaded to TESTING2 - Press enter to continue"