# setup on server to make changes to this source code

# clone to the server
git clone https://github.com/undoLogic/setupCase-boilerplate.git .

git fetch origin

# server has different ownership from basedir so use this to block the warning
git config --global --add safe.directory /home/undoweb/www/testboiler

# see the remote branches (ensure you fetch it first)
git branch -r

# add without the origin as that was causing an issue
git checkout -b 2023-04-07-undoWeb

# use merge by default
git config pull.rebase false

# pull any chnages
git pull origin 2023-04-07-undoWeb

# Install CakePHP 4 on empty project with authentication
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks on top of CakePHP
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

# add new files from cakePHP installation to git - need this for any delete files as well
git add --all

#add identity so we can push (one time)
git config --global user.email "support@undologic.com"
git config --global user.name "undoLogic"

# Commit
git commit -m 'Installed cakePHP and codeblocks'

# make sure you have setup personal access tokens (ensure organization is allowed)
# https://github.com/settings/tokens?type=beta

# remember our tokens so we don't have to add it in each time
git config --global credential.helper cache
# if you want to clear the token
# git config --global --unset credential.helper

# push to server
git push -u origin --all

# your project is now setup in GitHub
# Next you can checkit out on PHPstorm and then push your changes as you work to your server