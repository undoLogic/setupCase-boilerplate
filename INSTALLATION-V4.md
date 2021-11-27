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
# navigate into /DockerStage directory and start it up
cd DockerStage
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

### Option A. Automated CakePHP Install using Composer
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

### Option B. Manual CakePHP install

Navigate to the CakePHP github releases page
```shell
https://github.com/cakephp/cakephp/releases
```
Find the most recent CakePHP 4 version and download the cakephp-4-3-1.zip to your computer
-> NOTE: The source-code will only have CakePHP library without the app skeleton so do NOT download that one, instead the other link
unzip and copy into the root

### Verify running
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

```shell
curl https://github.com/startbootstrap/startbootstrap-sb-admin-2/archive/gh-pages.zip src/webroot/modules/layout/.
```

https://graygrids.com/templates/category/free-html-templates/

##Step 3: Add Layout
Copy the index file from modules/layout/index.html

WEBROOT/modules/layoutName Now integrate into (templates/layout/new.php)

Add variable in App_controller in the beforeFilter()
$this->set('baseLayout', Router::url('/').'modules'.DS.'layout'.DS);

Now in your view we need to link to the modules path -> anywhere you see 'src="assets......' will instead be 'src="assets......' -> This also applies to href, url etc

```angular2html
<img src="assets/img.jpg"/>
```
will become
```angular2html
<img src="<?= $baseLayout; ?>assets/img.jpg"/>
```

IMPORTANT: Make sure you do NOT change href='#' as this will cause problems if you add "....$base; ?>#...."

Now that the layout is working this means you can navigate to your browser and see it displaying correctly in the view

Download any template / layout and integrate into the CakePHP structure with these instructions (below)


lastly, you need to find the shared portion of the layout for all the pages and add the following code there
-> this will allow to have many different pages which all share the same layout

```angular2html
<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
```

Now you can test it out and you should see the nice layout

```angular2html
http://localhost/src
```

### Create pages and link together

IMPORTANT: Before this can work you need to comment out the default pages routing
```
/src/config/routes.php

### ensure this is commented so it does not activate
### -> This causes issues with caps on url->builder

//$builder->connect('/pages/*', 'Pages::display');
```

ensure you have in your appController or pagescontroller outside of your class
```angular2html
    use Cake\Routing\Router;
```

```angular2html
function newpage() {
    $this->viewBuilder()->setLayout('new');
    $this->set('baseLayout', Router::url('/').'modules'.DS.'layout'.DS);
}
```

and create a second page

```angular2html
function secondpage() {
    $this->viewBuilder()->setLayout('new');
    $this->set('baseLayout', Router::url('/').'modules'.DS.'layout'.DS);
}
```

#### Create the nagivation

Modify the menu on the layout and add the following to jump between the pages. 

Here is the href
```angular2html
<?= $this->Url->build(['controller' => 'Pages', 'action' => 'newpage']); ?>
```

so when you add to the link in the page you get 

```angular2html
    <a class="nav-link" href="<?= $this->Url->build(['controller' => 'Pages', 'action' => 'secondpage']); ?>">
        <span>New Page</span>
</a>
```

Good Stuff ! You have now:
- prepared a new project with the latest CakePHP v2 and docker
- integrated it into our SetupCase library
- added to a professional layout
- created a basic navigation

This concludes our Quick-Start guide !

## End of Test / Quick Start