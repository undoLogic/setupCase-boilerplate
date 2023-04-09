#!/bin/bash
# download the setupCase libraries
svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

# create a git repo to track our files
git init -b master
git add . && git commit -m "Creating new project"

#get the domain from the user
read -p 'Web address from Step 2: ' webAddress

# connect to our server git directory @todo can be connected intially on git init ?
git remote add origin "$webAddress"
git push -u origin master

# all our files are now available from the git repo on our server