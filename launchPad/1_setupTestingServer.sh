#!/bin/sh
source Z_share.sh

if [ $TESTING_COPY_SRC_TO_ROOT = true ]
then
  # WILL rsync the branch to the root (required for authentication / login)
  COMMAND="$TESTING_USER@$TESTING_URL cd $TESTING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone $TESTING_GIT_ADDRESS --branch $GITHUB_CURRENT_BRANCH --single-branch $TESTING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  && rsync -av $TESTING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ." && echo ""
else
  # WILL rsync the branch to the root (required for authentication / login)
  COMMAND="$TESTING_USER@$TESTING_URL cd $TESTING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone $TESTING_GIT_ADDRESS --branch $GITHUB_CURRENT_BRANCH --single-branch $TESTING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  " && echo ""
fi

echo $COMMAND

echo " "
read -p "Press enter to update TESTING server"

ssh $COMMAND
#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
#"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING_URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING_URL/

read -p "Uploaded to TESTING - Press enter to continue"