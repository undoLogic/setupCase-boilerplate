#!/bin/sh
# run this file from cron which will only startup the run file if it is NOT running
ps -ef | grep -v grep | grep "SetupCase-Caching" && echo "caching already running - nothing to do" || /var/www/html/caching/SetupCase-Caching.sh

### Create cron to ensure this stays running
# ps -ef | grep -v grep | grep "SetupCase-Caching" && echo "running" || echo "not"
# ps -ef | grep -v grep | grep "SetupCase-Caching" && echo "caching already running - nothing to do" || /var/www/html/caching/run.sh
#crontab -l ; echo "* * * * * echo "Hello world" >> /var/log/cron.log"
# not working