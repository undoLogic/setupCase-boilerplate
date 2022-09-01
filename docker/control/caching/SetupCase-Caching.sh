#!/bin/sh

_isRunning() {
  ps -ef | grep -v grep | grep "SetupCase-Caching"
}
if _isRunning;
then
  # create the base directory
  # @todo add detection if already exists
  mkdir /var/www/vhosts/website.com/internal
  chmod 777 /var/www/vhosts/website.com/internal

  while :
  do
    # @todo create a ctrl+c detection as it get's into a loop and hard to get out
    rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
    trap "echo Exited!; exit;" SIGINT SIGTERM
    date +%T
    #run once a second
    sleep 1
  done
else
  echo "Already running - do nothing"
fi