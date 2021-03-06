# Variables
SSH_HOST=$(grep '^ *"LIVE_URL":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SSH_USER=$(grep '^ *"LIVE_USER":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
GITHUB_USER_SLASH_PROJECT=$(grep '^ *"GITHUB_USER_SLASH_PROJECT":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SERVER_TMP_LOCATION_ABSOLUTE_PATH=$(grep '^ *"SERVER_TMP_LOCATION_ABSOLUTE_PATH":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SRC_FILES_RELATIVE_PATH=$(grep '^ *"SRC_FILES_RELATIVE_PATH":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_URL=$(grep '^ *"TESTING_URL":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_ABSOLUTE_PATH=$(grep '^ *"TESTING_ABSOLUTE_PATH":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_ABSOLUTE_PATH=$(grep '^ *"STAGING_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_URL=$(grep '^ *"STAGING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_URL=$(grep '^ *"LIVE_URL":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_ABSOLUTE_PATH=$(grep '^ *"LIVE_ABSOLUTE_PATH":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
GITHUB_HOST=$(grep '^ *"GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
BROWSER_LOCAL_PATH_WITH_PROGRAM=$(grep '^ *"BROWSER_LOCAL_PATH_WITH_PROGRAM":' settings.json  | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
#
#
GITHUB_CURRENT_BRANCH=$(git branch --show-current)
if [ $GITHUB_CURRENT_BRANCH = "master" ]; then
  GITHUB_CURRENT_BRANCH="master"
else
  GITHUB_CURRENT_BRANCH=$GITHUB_CURRENT_BRANCH
fi

echo "ssh" $SSH_USER@$SSH_HOST "rsync -av --omit-dir-times --no-perms $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""

echo "LIVE URL:" $LIVE_URL

read -p "Press enter to go LIVE"

# Rsync the files from test location to LIVE
ssh $SSH_USER@$SSH_HOST "rsync -av --omit-dir-times --no-perms $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""
#open firefox new tab with link
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $LIVE_URL

read -p "LIVE - Press enter to close"