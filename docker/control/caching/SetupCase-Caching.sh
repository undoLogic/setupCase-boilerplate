#!/bin/sh

#INPUT="hellohowareyou"
#SUBSTRING=$(echo $INPUT| cut -c 1-3)
#echo $SUBSTRING

#echo "${TEST:10:15}"

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
  #sleep 1
  dateIS=$(date +"%M:%S")

  # new method
  #find /var/www/vhosts/website.com/www/sourceFiles/ -amin -0.2 -type f | xargs cp -i /var/www/vhosts/website.com/www/test/
  find /var/www/vhosts/website.com/www/sourceFiles/ -amin -1 -type f -name '*.php' | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); cp $line $result; SUBSTRING=$(echo $line| rev | cut -c 1-40 | rev);  echo "${dateIS} - updated: ...${SUBSTRING}"; } done

  # Old method
  # rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
  # trap "echo Exited!; exit;" SIGINT SIGTERM
done