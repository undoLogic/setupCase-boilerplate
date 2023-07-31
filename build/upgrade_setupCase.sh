#!/bin/bash

# @todo this should be merged with install_setupCase to not repeat the code

echo "- - - - - - - - - - - - - - - - - - - - - - - - - Upgrading SetupCase..."

svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
echo "- - - - - - - - - - - - - - - - - - - - - - - - - installing cakePHP with authentication"
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
echo "- - - - - - - - - - - - - - - - - - - - - - - - - integrating SetupCase codeblocks"
rsync -av --no-perms --omit-dir-times --fake-super codeBlocks/cakePHP/4.1/. sourceFiles/.

# remove git ignore in the cake directory since we have our own git ignore in our boilerplate files
rm -rf sourceFiles/.git*


#
git add . && git commit -m "Creating new project"

git push -u origin master
# you need to manually push in
git push https://github.com/company/project.git
# you will then be prompted for your username / PAT token (password)

# locally you can now update and get the files
