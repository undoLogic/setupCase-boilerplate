# setupCase-boilerPlate Version 2
setupCase.com project base - Manage and launch your project with Docker

## Test / Quick Start Instructions (Less than an hour)

Here is a basic test / quick start guide which shows you how the overall technology stack works. 
When complete you will have:
- prepared a new project with the latest CakePHP v2 and docker using powershell / terminal
- integrated it into our SetupCase library
- integrated a free finalized layout into cakePHP
- customized the visuals and added new pages
- Verified and modified the responsive design for different mobile devices !

### Requirements to run:
- Windows 10 PRO with virtualization activated OR MacOS
- SVN installed (Easy way to install: https://community.chocolatey.org/packages/svn OR https://brew.sh/)
- Docker installed (https://www.docker.com/) & Docker-compose
- Powershell / Terminal

First we need to export our source files to your computer. Navigate to an empty directory
```angular2html
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/ . --force
```

Next we need to add cakePHP 2.x
```angular2html
# this is an old branch, so you need to find the latest tag https://github.com/cakephp/cakephp/tags
# copy the link for the Source code .zip download EG:
# https://github.com/cakephp/cakephp/archive/refs/tags/2.10.24.zip
svn export https://github.com/cakephp/cakephp/tags/2.10.24
mv 2.10.24 src

#remove files (as they are being added in our root instead)
rm src/.gitignore
rm src/.gitattributes

# Copy our standard libraries ontop of cakePHP
rsync -av libraries/cakePHP/2/. src/app/.
```

Now we can startup our docker

- Ensure you have installed docker from the website https://www.docker.com/

```angular2html
# navigate into /DockerStage directory and start it up
./1startDocker.sh
```

Docker will start and download all the files which are required. When complete you can open localhost in your favourite browser
```angular2html
http://localhost/
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