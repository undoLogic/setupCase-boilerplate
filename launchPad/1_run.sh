#!/bin/bash
source Z_share.sh

options=("upload to test" "upload to staging" "GO LIVE!")

echo "Please select an option:"

COPY_SRC_TO_ROOT=false

select opt in "${options[@]}"; do
  case $opt in
    "upload to test")
      echo "You chose to upload to test."
      USER=$TESTING_USER
      URL=$TESTING_URL
      GIT_ADDRESS=$TESTING_GIT_ADDRESS
      ABSOLUTE_PATH=$TESTING_ABSOLUTE_PATH
      COPY_SRC_TO_ROOT=$TESTING_COPY_SRC_TO_ROOT
      break
      ;;
    "upload to staging")
      echo "You chose to upload to staging."
      USER=$STAGING_USER
      URL=$STAGING_URL
      GIT_ADDRESS=$STAGING_GIT_ADDRESS
      ABSOLUTE_PATH=$STAGING_ABSOLUTE_PATH
      COPY_SRC_TO_ROOT=$STAGING_COPY_SRC_TO_ROOT
      break
      ;;
    "GO LIVE!")
      echo "You chose to upload to live."
      USER=$LIVE_USER
      URL=$LIVE_URL
      GIT_ADDRESS=$LIVE_GIT_ADDRESS
      # These vars are used as is
      # STAGING_ABSOLUTE_PATH=$STAGING_ABSOLUTE_PATH
      # LIVE_ABSOLUTE_PATH=$LIVE_ABSOLUTE_PATH
      break
      ;;
    *)
      echo "Invalid option. Please try again."
      ;;
  esac
done

# Create the command based
if [[ $opt == "upload to test" || $opt == "upload to staging" ]]; then
  COMMAND="$USER@$URL cd $ABSOLUTE_PATH && rm -rf $GITHUB_CURRENT_BRANCH \
  && git clone \"https://\$(php -r 'echo env(\"PAT\", get_cfg_var(\"PAT\"));')@$GIT_ADDRESS\" \
  --branch $GITHUB_CURRENT_BRANCH --single-branch $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH\
  "

  if [ $COPY_SRC_TO_ROOT = true ]
  then
    #Rsync files to root
    COMMAND+=" && rsync -av $ABSOLUTE_PATH/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/ ."
  else
    # will NOT rsync to root
    COMMAND+=" "
  fi

  # for windows
  COMMAND+=""
  echo "$COMMAND"
else
  echo "this will be LIVE"
  COMMAND="$USER@$URL rsync -av --omit-dir-times --no-perms $STAGING_ABSOLUTE_PATH/. $LIVE_ABSOLUTE_PATH/." && echo ""
  echo "ssh $COMMAND"
fi

read -p "Press ENTER to SSH and run COMMAND"

ssh $COMMAND

#open firefox new tab with link
# figure out how to pass spaces from the settings page to here as the space is ending the variable
#"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $TESTING_URL/$GITHUB_CURRENT_BRANCH/$SRC_FILES_RELATIVE_PATH/
"C:\Program Files\Firefox Developer Edition\firefox.exe" -new-tab $URL/

read -p "Complete - Press enter to close this window"

