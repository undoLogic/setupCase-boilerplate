#!/usr/bin/env bash
apt update && apt upgrade -y
apt install php-cli unzip curl -y
cd ~
curl -sS https://getcomposer.org/installer | php
mv /root/composer.phar /usr/local/bin/composer
composer --version