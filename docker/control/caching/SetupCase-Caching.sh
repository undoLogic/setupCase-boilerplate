#!/bin/sh

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
 dateIS=$(date +"%M:%S")
  DIR="/var/www/vhosts/website.com/www/sourceFiles/"
  if [ ! -d "$DIR" ]; then
    echo "$dateIS - dir: 'sourceFiles' is missing - run ./2install-cake4.sh - waiting for 10 seconds ..."
    sleep 10
    else
        find /var/www/vhosts/website.com/www/sourceFiles/ -amin -1 -type f -name '*.php' | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); cp $line $result; SUBSTRING=$(echo $line| rev | cut -c 1-40 | rev);  echo "${dateIS} - updated: ...${SUBSTRING}"; } done

    # Old method
    # rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
    # trap "echo Exited!; exit;" SIGINT SIGTERM
  fi
done