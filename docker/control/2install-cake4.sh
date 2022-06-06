#!/usr/bin/env bash
php composer.phar create-project --prefer-dist cakephp/app /var/www/vhosts/website.com/www/src
#we need Authentication for our hashing algorithm
./composer.phar require "cakephp/authentication:^2.0" -d/var/www/vhosts/website.com/www/src
