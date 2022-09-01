#!/bin/sh

# create the base directory
# @todo add detection if already exists
mkdir /var/www/vhosts/website.com/internal
chmod 777 /var/www/vhosts/website.com/internal

# @todo prepare the tmp / logs as chmod 777

#whole directory slower
#rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/. /var/www/vhosts/website.com/internal/.

#Single directories to make it faster
# rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/config/. /var/www/vhosts/website.com/internal/config/.
# rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/src/. /var/www/vhosts/website.com/internal/src/.
# rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/templates/. /var/www/vhosts/website.com/internal/templates/.

while :
do
  # @todo create a ctrl+c detection as it get's into a loop and hard to get out
  rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/. /var/www/vhosts/website.com/internal/. --delete
  trap "echo Exited!; exit;" SIGINT SIGTERM
  date +%T

  #run once a second
  sleep 1
  #  rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/config/. /var/www/vhosts/website.com/internal/config/.
  #  date +%T
  #  rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/src/. /var/www/vhosts/website.com/internal/src/.
  #  date +%T
  #  rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/src/templates/. /var/www/vhosts/website.com/internal/templates/.
  #  date +%T
  # echo "infinite"
done
