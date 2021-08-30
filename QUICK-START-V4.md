# setupCase-boilerPlate Version 4
setupCase.com project base - Manage and launch your project with Docker and CakePHP

## Test / Quick Start Instructions (Less than an hour)

Here is a basic test / quick start guide which shows you how the overall technology stack works.
When complete you will have:
- prepared a new project with the latest CakePHP v2 and docker using powershell / terminal
- integrated it into our SetupCase library
- integrated a free finalized layout into cakePHP V4
- customized the visuals and added new pages
- Verified and modified the responsive design for different mobile devices !

###Requirements to run:
- Windows 10 PRO with virtualization activated OR MacOS
- SVN installed (Easy way to install: https://community.chocolatey.org/packages/svn OR https://brew.sh/)
- Docker installed (https://www.docker.com/) & Docker-compose
- Powershell / Terminal

First we need to export our source files to your computer. Navigate to an empty directory
```angular2html
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/ . --force
```

Next we need to start up Docker

- Ensure you have installed docker from the website and it is running https://www.docker.com/

Using Terminal: 
```angular2html
# navigate into /docker directory and start it up
cd docker
./1startDocker.sh
```

Docker will start and download all the files which are required. When complete you can open localhost in your favourite browser and you will see a directory structure.

```angular2html
http://localhost/
```

Next we are going to Login to our container to continue (ideal to avoid extra installation on the host)
```angular2html
# within the docker folder run:
./2loginDockerContainer.bat
```

Composer is not auto-loaded. To setup:
```angular2html
# After you have logged into the docker container
./install-composer.sh
```

Now we are ready to install CakePHP 4.x
- this will install to /src in our files. Allowing to navigate (in your browser to) localhost/src/
```angular2html
php composer.phar create-project --prefer-dist cakephp/app /var/www/vhosts/website.com/www/src

# Removing these files will ensure we can control from our SetupCase structure only (eg we WANT to include our database files etc)
rm /var/www/vhosts/website.com/www/src/.gitignore
rm /var/www/vhosts/website.com/www/src/.gitattributes
```

Verify running
- Go to your browser and verify the CakePHP is running without any missing dependancies:
```angular2html
http://localhost/src/
```

Copy our Library for SetupCase base functionality
```angular2html
# Copy our standard libraries on top of cakePHP
rsync -av /var/www/vhosts/website.com/www/libraries/cakePHP/4/. /var/www/vhosts/website.com/www/src/.
```

Start-up: You should see all the files / folders in the directory. Click on phpInfo and ensure php is working correctly. You know it has started up correctly.

Next we are going to add a professional layout
- We always integrate professional layouts and modify in line with our clients requests. This streamlines the development process.
- We always purchase layouts, but for testing you can find free templates / layouts to download to test it all out for free

https://startbootstrap.com/?showPro=false&showVue=false&showAngular=false

https://graygrids.com/templates/category/free-html-templates/

Download any template / layout and integrate into the CakePHP structure with these instructions (below)
- https://github.com/undoLogic/setupCase-boilerplate#step-12-add-layout
- Now when you navigate to your browser you should see the layout displaying correctly in your browser

```angular2html
http://localhost/src
```

Responsive Design: Ensure the layout looks good for all devices by making changes to the responsive design per our basic instructions:

https://github.com/undoLogic/setupCase-boilerplate/blob/main/PROGRAMMING-GUIDE.md#step-12b-responsive-design

Good Stuff ! You have now:
- prepared a new project with the latest CakePHP v2 and docker
- integrated it into our SetupCase library
- added to a professional layout
- customized the visuals and added new pages
- Verified it is working on different mobile devices !

This concludes our Quick-Start guide !

## End of Test / Quick Start