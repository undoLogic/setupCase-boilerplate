#!/bin/sh

#!/bin/sh
source Z_share.sh


if [ $STAGING_COPY_SRC_TO_ROOT = true ]
then
  # WILL rsync the branch to the root (required for authentication / login)
  COMMAND="$STAGING_USER@$STAGING_URL cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone git@$STAGING_GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  && rsync -av $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ." && echo ""
else
  # will NOT rsync branch to the root
  COMMAND="$STAGING_USER@$STAGING_URL cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone git@$STAGING_GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH \
  " && echo ""
fi


echo $COMMAND

echo " "
read -p "Press enter to update STAGING server"

ssh $COMMAND
#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $STAGING_URL/

read -p "Uploaded to STAGING - Press enter to continue"

