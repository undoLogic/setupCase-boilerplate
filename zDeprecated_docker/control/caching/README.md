The translation layer between windows and docker is slow, so get around this you can enable internal caching for our SetupCase boiler plate 
- This copies your source files which you have modified every few seconds into the container
- You get a huge performance increase as the 

Open /docker/sites-available/000-default.conf and make sure the following files are uncommented / commented
```shell
#line 20 comment this line
#DocumentRoot /var/www/vhosts/website.com/www
#line 23 UNcomment this line
DocumentRoot /var/www/vhosts/website.com/internal

...

#line 38 comment this line
#<Directory "/var/www/vhosts/website.com/www">
#line 41 UNcomment this line
<Directory "/var/www/vhosts/website.com/internal">
```

Next you need to restart the docker from within docker container:
```shell
#first from a terminal navigate to docker folder
cd docker
#now within the container 
./1reStartDocker.sh
#or if not yet started
./1startDocker.sh
#now login the container
./2loginDockerContainere.bat
#turn on caching
./6runCaching.sh
```

You will now see first all the files are initially synced (it can take a minute or so)

Then you will see a log of the files that are copied to the cache

NOTE: As you are editing your files you will have to give a few seconds for the changes to be detected and copied into the cache

Now the response time should be under 100ms opposed to over 2 seconds :)
