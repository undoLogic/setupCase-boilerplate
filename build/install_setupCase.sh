#!/bin/bash

echo "- - - - - - - - - - - - - - - - - - - - - - - - - Installing SetupCase..."
#get the domain from the user
read -p 'Git "Web address" from Step 2: ' webAddress

echo "- - - - - - - - - - - - - - - - - - - - - - - - - cloning git repo: $webAddress"

## from step 2 clone the git repo
# avoid error permission denied
git config --global --unset credential.helper
git clone $webAddress tmp
rsync -av --no-perms --omit-dir-times --fake-super tmp/. .
rm -rf tmp

read -p 'ready to install' read

# download the setupCase libraries DEPRECATED
# svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# ensure all the previous git is gone
# rm -rf .git*



# Clone the repository (replace URL with your repository URL)
git clone --depth=1 https://github.com/undoLogic/setupCase-boilerplate.git tmpSetupCase

# we do not want any git association at all
rm -rf tmpSetupCase/.git

# merge into our existing git repo
rsync -av --no-perms --omit-dir-times --fake-super tmpSetupCase/. .

# cleanup / delete the tmp dir
rm -rf tmpSetupCase




##################################################################################################### Install CakePHP 4
echo "- - - - - - - - - - - - - - - - - - - - - - - - - installing cakePHP with authentication"
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
echo "- - - - - - - - - - - - - - - - - - - - - - - - - integrating SetupCase codeblocks"
rsync -av --no-perms --omit-dir-times --fake-super codeBlocks/cakePHP/4.x/. sourceFiles/.

# remove git ignore in the cake directory since we have our own git ignore in our boilerplate files
rm -rf sourceFiles/.git*

# deprecated - create a git repo to track our files
# git init -b master

read -p 'Add source files to git repo' read

git add . && git commit -m "Creating new project"

git push -u origin master

# all our files are now available from the git repo on our server