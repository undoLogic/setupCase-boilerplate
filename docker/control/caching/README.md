The translation layer between windows and docker is slow, so get around this you can enable internal caching 
- This copies your source files which you have modified every few seconds into the container
- You get a huge performance increase as the 

Open /docker/sites-available/000-default.conf and make sure the following files are uncommented / commented
```shell
#DocumentRoot /var/www/vhosts/website.com/www
DocumentRoot /var/www/vhosts/website.com/internal

...

#<Directory "/var/www/vhosts/website.com/www">
<Directory "/var/www/vhosts/website.com/internal">
```

Activate the crontab which starts up the process to continually copy the files into the internal caching location
```shell
# concept only
# figure out how to ensure this process is only restarted after each time rsync stops
watch /var/www/vhosts/website.com/www/docker/control/automation/auto_rsync_to_internal.sh
```
