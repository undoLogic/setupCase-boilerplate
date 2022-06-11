#!/usr/bin/env bash
#master (i believe)
#php composer.phar create-project --prefer-dist cakephp/app /var/www/vhosts/website.com/www/src

#release 4.3.x
php composer.phar require --update-with-dependencies "cakephp/cakephp:4.3.*" -d/var/www/vhosts/website.com/www/src

#we need Authentication for our hashing algorithm
./composer.phar require "cakephp/authentication:^2.0" -d/var/www/vhosts/website.com/www/src

# we do not need these files as we are taking in the parent directory
rm /var/www/vhosts/website.com/www/src/.gitignore
rm /var/www/vhosts/website.com/www/src/.gitattributes
