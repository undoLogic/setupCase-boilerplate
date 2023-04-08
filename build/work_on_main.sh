# setup on server to make changes

git clone https://github.com/undoLogic/setupCase-boilerplate.git .

git fetch origin

# server has different ownership so use this
git config --global --add safe.directory /home/undoweb/www/testboiler

# see the remote branches (ensure you fetch it first)
#git branch -a
git branch -r

# checkout a branch - this did not work
# git checkout -b origin/2023-04-07-undoWeb

# add without the origin as that was causing an issue
git checkout -b 2023-04-07-undoWeb

git config pull.rebase false

git pull origin 2023-04-07-undoWeb

# Install CakePHP 4 on empty project
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks ontop of CakePHP
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

# add new files to git - need this for delete as well
git add --all

#add identity
git config --global user.email "support@undologic.com"
git config --global user.name "undoLogic"

git commit -m 'Installed cakePHP and codeblocks'

# make sure you have setup personal access tokens
# ensure organization is allowed
# https://github.com/settings/tokens?type=beta

# push to server
git push -u origin --all

#enter username
