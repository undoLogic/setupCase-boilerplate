# Setup
# Requires deploy keys setup on github
# get the public key from the live server (ssh into the server)
# First time only: (subsequent times this will already be created - to check ls -la and you will see id_rsa*)
# ssh-keygen -t ed25519 -C "support@undologic.com"
# cd ~/.ssh
# cat id_ed25519.pub
# copy that public key
# Github.com -> Settings -> Deploy keys
# Add Deploy Key
# Add comment which server (so you remember later)
# Paste in the key into the box
# IMPORTANT: You MUST manually connect the first time so the server before you can automate with the launch system
SSH_HOST=$(grep '^ *"STAGING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SSH_USER=$(grep '^ *"STAGING_USER":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
GITHUB_USER_SLASH_PROJECT=$(grep '^ *"GITHUB_USER_SLASH_PROJECT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SRC_FILES_RELATIVE_PATH=$(grep '^ *"SRC_FILES_RELATIVE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_URL=$(grep '^ *"STAGING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_ABSOLUTE_PATH=$(grep '^ *"STAGING_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
GITHUB_HOST=$(grep '^ *"GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_URL=$(grep '^ *"STAGING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
BROWSER_LOCAL_PATH_WITH_PROGRAM=$(grep '^ *"BROWSER_LOCAL_PATH_WITH_PROGRAM":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
#
#
#
GITHUB_CURRENT_BRANCH=$(git branch --show-current)
if [ $GITHUB_CURRENT_BRANCH = "master" ]; then
  GITHUB_CURRENT_BRANCH="master"
else
  GITHUB_CURRENT_BRANCH="$GITHUB_CURRENT_BRANCH"
fi

# echo $SSH_USER@$SSH_HOST "cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH && svn export --force --no-auth-cache --username $GITHUB_USERNAME --password $GITHUB_PASSWORD https://@github.com/$GITHUB_USER_SLASH_PROJECT/$GITHUB_CURRENT_BRANCH $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH" && echo ""
echo $SSH_USER@$SSH_HOST "cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH && git clone git@$GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH" && echo ""

read -p "Press enter to update TESTING server"

#ssh $SSH_USER@$SSH_HOST "cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH && svn export --force --no-auth-cache --username $GITHUB_USERNAME --password $GITHUB_PASSWORD https://@github.com/$GITHUB_USER_SLASH_PROJECT/$GITHUB_CURRENT_BRANCH $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH" && echo ""
ssh $SSH_USER@$SSH_HOST "cd $STAGING_ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH && git clone git@$GITHUB_HOST:$GITHUB_USER_SLASH_PROJECT.git --branch $GITHUB_CURRENT_BRANCH --single-branch $STAGING_ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH" && echo ""


#open firefox new tab with link
#figure out how to pass spaces from the settings page to here as the space is ending the variable
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $STAGING_URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/

read -p "Uploaded to TESTING - Press enter to continue"