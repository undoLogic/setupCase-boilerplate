#!/bin/sh

# cp --parents /var/www/vhosts/website.com/www/sourceFiles/src/Controller/AppController.php /var/www/vhosts/website.com/www/test
# find /var/www/vhosts/website.com/www/sourceFiles/src/Controller/AppController.php -type f | cpio -p -dumv /var/www/vhosts/website.com/www/test/.

# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f | sed -e 's/sourceFiles/internal/' |

# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f | while read -r line; do { VAR="123"; echo "cp $line " sed -e 's/sourceFiles/internal/';} done

# result=$(echo "$firstString" | sed "s/sourceFiles/internal/")
# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f | while read -r line; do echo $line | sed -e 's/sourceFiles/internal/'; done
# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f \( -name "sourceFiles")

#working
# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); echo "cp $line $result";} done
# find /var/www/vhosts/website.com/www/sourceFiles/ -amin -30 -type f | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); cp $line $result;} done
# cp /var/www/vhosts/website.com/www/sourceFiles/src/Controller/AppController.php /var/www/vhosts/website.com/internal/src/Controller/AppController.php

# RUNNING=0
# ps -ef | grep -v grep | grep "SetupCase-Caching" && RUNNING=1 || RUNNING=2
# ps -ef | grep -v grep | grep "33333333333" && RUNNING=1 || RUNNING=2
# echo ${RUNNING}

# create the base directory
# @todo add detection if already exists
DIR="/var/www/vhosts/website.com/internal"
if [ ! -d "$DIR" ]; then
  ### Directory already exists ###
  mkdir ${DIR}
  chmod 777 ${DIR}
  ### First time let's rsync the entire directory
  rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
fi

echo "Starting to cache modified files"
while :; do
  sleep 1
  date +%T
  # new method
  #find /var/www/vhosts/website.com/www/sourceFiles/ -amin -0.2 -type f | xargs cp -i /var/www/vhosts/website.com/www/test/
  #find /var/www/vhosts/website.com/www/sourceFiles/ -amin -1 -type f -name '*.php' | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); cp $line $result;} done
  # Old method
  # rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
  # trap "echo Exited!; exit;" SIGINT SIGTERM
done
