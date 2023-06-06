#!/bin/bash

echo "- - - - - - - - - - - - - - - - - - - - - - - - - Installing SetupCase..."
#get the domain from the user
read -p 'Git "Web address" from Step 2: ' webAddress

echo "- - - - - - - - - - - - - - - - - - - - - - - - - cloning git repo: $webAddress"

# from step 2 clone the git repo
git clone $webAddress tmp
rsync -av tmp/. .
rm -rf tmp

read -p 'ready to install' read

# download the setupCase libraries
svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
echo "- - - - - - - - - - - - - - - - - - - - - - - - - installing cakePHP with authentication"
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
echo "- - - - - - - - - - - - - - - - - - - - - - - - - integrating SetupCase v4.1 codeblocks"
rsync -av codeBlocks/cakePHP/4.1/. sourceFiles/.

# remove git ignore in the cake directory since we have our own git ignore in our boilerplate files
rm -rf sourceFiles/.git*

# deprecated - create a git repo to track our files
# git init -b master

read -p 'Add source files to git repo' read

git add . && git commit -m "Creating new project"

git push -u origin master

# all our files are now available from the git repo on our server