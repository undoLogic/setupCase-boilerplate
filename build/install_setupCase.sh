# Create a new subdomain and cd to that folder using SSH

# Checkout our SetupCase structure
# This assumes you have already run this command from the website
# first time you need to setup as follows or if you are checking out github then ignore this
svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks ontop of CakePHP
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

# create a new git repo
# git init -b main

# create the repo in github

# echo "# test123" >> README.md
git init -b main
git add . && git commit -m "Creating new project"

# rename branch to main
# git branch -M main

#get the domain from the user

git remote add origin https://github.com/undoLogic/test123.git
git push -u origin main
