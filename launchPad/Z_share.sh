#!/bin/sh
# Prepares the variables for the scripts
# shellcheck disable=SC2034
TESTING_URL=$(grep '^ *"TESTING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
# shellcheck disable=SC2034
TESTING_USER=$(grep '^ *"TESTING_USER":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_GITHUB_HOST=$(grep '^ *"TESTING_GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_USE_PAT=$(grep '^ *"TESTING_USE_PAT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_GIT_ADDRESS=$(grep '^ *"TESTING_GIT_ADDRESS":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_ABSOLUTE_PATH=$(grep '^ *"TESTING_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING_COPY_SRC_TO_ROOT=$(grep '^ *"TESTING_COPY_SRC_TO_ROOT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')

TESTING2_URL=$(grep '^ *"TESTING2_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
# shellcheck disable=SC2034
TESTING2_USER=$(grep '^ *"TESTING2_USER":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING2_GITHUB_HOST=$(grep '^ *"TESTING2_GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING2_USE_PAT=$(grep '^ *"TESTING2_USE_PAT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING2_GIT_ADDRESS=$(grep '^ *"TESTING2_GIT_ADDRESS":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING2_ABSOLUTE_PATH=$(grep '^ *"TESTING2_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
TESTING2_COPY_SRC_TO_ROOT=$(grep '^ *"TESTING2_COPY_SRC_TO_ROOT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')

# Staging
STAGING_URL=$(grep '^ *"STAGING_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_USER=$(grep '^ *"STAGING_USER":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_GITHUB_HOST=$(grep '^ *"STAGING_GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_USE_PAT=$(grep '^ *"STAGING_USE_PAT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_GIT_ADDRESS=$(grep '^ *"STAGING_GIT_ADDRESS":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_ABSOLUTE_PATH=$(grep '^ *"STAGING_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
STAGING_COPY_SRC_TO_ROOT=$(grep '^ *"STAGING_COPY_SRC_TO_ROOT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')

# Live
LIVE_URL=$(grep '^ *"LIVE_URL":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_USER=$(grep '^ *"LIVE_USER":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_GITHUB_HOST=$(grep '^ *"LIVE_GITHUB_HOST":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
LIVE_ABSOLUTE_PATH=$(grep '^ *"LIVE_ABSOLUTE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
# Other
GITHUB_USER_SLASH_PROJECT=$(grep '^ *"GITHUB_USER_SLASH_PROJECT":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
SRC_FILES_RELATIVE_PATH=$(grep '^ *"SRC_FILES_RELATIVE_PATH":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')
# Browser to auto load
BROWSER_LOCAL_PATH_WITH_PROGRAM=$(grep '^ *"BROWSER_LOCAL_PATH_WITH_PROGRAM":' settings.json | awk '{ print $2 }' | sed -e 's/,$//' -e 's/^"//' -e 's/"$//')

# Figure out which github branch we are in
GITHUB_CURRENT_BRANCH=$(git branch --show-current)
if [ $GITHUB_CURRENT_BRANCH = "master" ]; then
  GITHUB_CURRENT_BRANCH="master"
else
  GITHUB_CURRENT_BRANCH="$GITHUB_CURRENT_BRANCH"
fi