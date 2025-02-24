# SetupCase - Docker

Our docker platform will enable you to work locally on your computer or with other team members

Use your powershell / terminal and navigate to the docker directory
```angular2html
cd docker
```

***

### Commands to use

Restart an already docker container
```
./1reStartDocker.sh
```

Start a docker container (will NOT stop running containers)
```
./1startDocker.sh
```

View the active logs and follow activity
```
./3logs.bat
```

Restart apache within the container (alpha with issues)
```
./5restartApache.sh
```

Save database state into the docker/sql/db.sql file (MacOS)
```angular2html
./5saveDbMac.sh
```


Save database state into the docker/sql/db.sql file (Windows)
```angular2html
./5saveDbWindows.sh
```

Cleanup the docker system, remove images etc. 
```angular2html
./8cleanup.sh
```

Rebuilt your docker image (when you modify the dockerfile)
```angular2html
./8rebuild-clean.sh
```

Stop Docker
```angular2html
./8stopDocker.sh
```

***

### support Files

docker-compose.yml
This file is what specifies all the docker components that will be connected together. i.e. if you want a database you would add 
to this file. If you want PHPMyAdmin you would add it here. This file also specifies which version of PHP you want to run 

***

### Directories

control
This is what is visible when you login to the linux container. Allows to run commands quickly without having to navigate to a different directory

ini
Hold the PHP.ini settings which is used by all versions of php

sites-available
Allows to modify the sites-available file that is used by PHP within the linux container

sql
Holds the database SQL files. ALL files within this directory are loaded when you start a docker container

web56
This is the dockerfile for php5.6, you can modify this file, and after you rebuild the changes will be available on your docker container

web71
This is the dockerfile for php 7.1

web72
This is the dockerfile for php 7.2

web74
This is the dockerfile for php 7.4


## Troubleshooting

Docker cannot start: listen tcp4 0.0.0.0:80: bind: address already in use
- This means apache is probably running
```shell
docker-compose down # first ensure we shutdown our docker
sudo lsof -i -P -n | grep <port number>
# if you see apache
killall apache2
```