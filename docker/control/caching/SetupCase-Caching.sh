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
    # new method
    #find /var/www/vhosts/website.com/www/sourceFiles/ -amin -0.2 -type f | xargs cp -i /var/www/vhosts/website.com/www/test/
    find /var/www/vhosts/website.com/www/sourceFiles/ -amin -1 -type f | while read -r line; do { result=$(echo "$line" | sed "s/www\/sourceFiles/internal/"); cp $line $result;} done

    # @todo create a ctrl+c detection as it get's into a loop and hard to get out
    # rsync -av --exclude='.git/' /var/www/vhosts/website.com/www/sourceFiles/. /var/www/vhosts/website.com/internal --delete
    # trap "echo Exited!; exit;" SIGINT SIGTERM
    date +%T
    #run once a second
    # sleep 1
  done
else
  echo "Already running - do nothing"
fi