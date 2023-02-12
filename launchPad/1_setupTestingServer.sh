#!/bin/sh
source share.sh

COMMAND="$TESTING_USER@$TESTING_URL cd $TESTING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
&& git clone git@$TESTING_GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $TESTING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
&& rsync -av $TESTING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ." && echo ""

echo $COMMAND

echo " "
read -p "Press enter to update TESTING server"

ssh $COMMAND
#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
#"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING_URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING_URL/

read -p "Uploaded to TESTING - Press enter to continue"