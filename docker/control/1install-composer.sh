#!/bin/sh



#####################################33 original script below

EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
RESULT=$?
rm composer-setup.php


sleep 2
# let's move our composer to the global use
mv composer.phar /usr/local/bin/composer


if [$RESULT]
then
echo "ERROR: Something went wrong with compose installation"
else
echo "SUCCESS: Installed composer to file in current directory"
fi
exit $RESULT



