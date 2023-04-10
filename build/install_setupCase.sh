#!/bin/bash

echo "- - - - - - - - - - - - - - - - - - - - - - - - - Installing SetupCase..."
#get the domain from the user
read -p 'Git "Web address" from Step 2: ' webAddress

echo "- - - - - - - - - - - - - - - - - - - - - - - - - cloning git repo: $webAddress"

# from step 2 clone the git repo
git clone $webAddress .

read -p 'ready to install' read

# download the setupCase libraries
svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
echo "- - - - - - - - - - - - - - - - - - - - - - - - - installing cakePHP with authentication"
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
echo "- - - - - - - - - - - - - - - - - - - - - - - - - integrating SetupCase codeblocks"
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

# deprecated - create a git repo to track our files
# git init -b master

git add . && git commit -m "Creating new project"

# deprecated - connect to our server git directory @todo can be connected intially on git init ?
# git remote add origin "$webAddress"

git push -u origin master

# all our files are now available from the git repo on our server