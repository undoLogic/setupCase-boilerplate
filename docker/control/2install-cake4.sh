#!/usr/bin/env bash
php composer.phar create-project --prefer-dist cakephp/app /var/www/vhosts/website.com/www/src

#we need Authentication for our hashing algorithm
./composer.phar require "cakephp/authentication:^2.0" -d/var/www/vhosts/website.com/www/src

# we do not need these files as we are taking in the parent directory
rm /var/www/vhosts/website.com/www/src/.gitignore
rm /var/www/vhosts/website.com/www/src/.gitattributes
