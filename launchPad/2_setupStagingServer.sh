#!/bin/sh

#!/bin/sh
source Z_share.sh

COMMAND="$STAGING_USER@$STAGING_URL cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
&& git clone git@$STAGING_GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
&& rsync -av $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ." && echo ""

echo $COMMAND

echo " "
read -p "Press enter to update TESTING server"

ssh $COMMAND
#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $STAGING_URL/

read -p "Uploaded to STAGING - Press enter to continue"

