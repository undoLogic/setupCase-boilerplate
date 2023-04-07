# Create a new subdomain and cd to that folder using SSH

# Checkout our SetupCase structure
# This assumes you have already run this command from the website
# svn export --force https://github.com/undoLogic/setupCase-boilerplate/trunk .

# Install CakePHP 4
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Install CakePHP Authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# copy our codeBlocks ontop of CakePHP
rsync -av codeBlocks/cakePHP/4/. sourceFiles/.

