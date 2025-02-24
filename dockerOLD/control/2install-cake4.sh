#!/usr/bin/env bash

# testing different methods to install
#master (i believe)
#php composer.phar create-project --prefer-dist cakephp/app /var/www/vhosts/website.com/www/sourceFiles

#mkdir /var/www/vhosts/website.com/www/sourceFiles
#release 4.3.x - this is only the library of cakePHP it seems
#php composer.phar require --update-with-dependencies "cakephp/cakephp:4.4.*" -d/var/www/vhosts/website.com/www/sourceFiles

# working version to install
composer create-project --prefer-dist cakephp/app:~4.0 /var/www/vhosts/website.com/www/sourceFiles

#we need Authentication for our hashing algorithm
composer require "cakephp/authentication:^2.0" -d/var/www/vhosts/website.com/www/sourceFiles

# we do not need these files as we are taking in the parent directory
rm /var/www/vhosts/website.com/www/sourceFiles/.gitignore
rm /var/www/vhosts/website.com/www/sourceFiles/.gitattributes
