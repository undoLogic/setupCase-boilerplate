# setupCase-boilerPlate Version 4
setupCase.com solution - Build and manage custom software and business websites
with our block programming on our Platform-as-a-service and minimize your local computer
dependancies.

## Overview Steps

1. [Initial Setup / Preparation](#step-1-initial-setup--preparation)
2. [Build a new CakePHP 4 project with our Platform-as-a-service](#step-2-build-a-new-cakephp-4-project-with-our-platform-as-a-service)
3. [Install software on your local computer with Chocolatey.org](#step-3-install-software-with-chocolateyorg)
4. [Checkout your new sourceFiles to your local computer](#step-4-checkout-your-new-sourcefiles-to-your-local-computer)
5. [Configure your IDE to automatically push changes to your server](#step-5-configure-your-ide-to-automatically-push-changes-to-your-server)
6. [Testing and watch updates on the test subdomain](#step-6-testing-and-watch-updates-on-the-test-subdomain)
7. [Integrate a professional visual layout to your project](#step-7-integrate-a-professional-visual-layout-to-your-project)
8. [Programming](#step-8-programming)
9. [Launch changes](#step-9-launch-changes)
10. [Optional: Convert to a dockerized container and launch your project on a popular VPS server](#step-10-convert-to-a-dockerized-container-for-vps-deployment)


### Step 1 Initial Setup / Preparation
- Enable SSH (Control panel -> SSH Access -> SSH access is disabled -> Click Enable)
- Activate Wget/Curl (Control panel -> SSH Access -> Network tools -> Enable)
- Create sub-domains (Control panel -> Sub Domains -> Create 'test' & 'repos')
  - You can create other sub-domains in the future for other projects 
  - Each subdomain you create is publically available eg if you create 'test' then you can go to http://test.domain.com
- Activate Git Repo (Control panel -> Git -> fill in form)
  - Domain: choose your main domain
  - Sub-domain choose 'repos'
  - Leave 'web access path' blank'
  - Name: use your project name
  - Desc: A short desc about your project
- IMPORTANT: Copy info
  - Keep the Web Address, username and password after the Git repo is created as we will use them again in the future steps
  - NOTE: There is a link allowing you to change the password if you like. We will not have any private data until later, so an easier password is good for setup and later you will push into github which is more secure

[back to top](#overview-steps)

### Step 2 Build a new CakePHP 4 project with our Platform-as-a-service
- Use powershell / terminal to access the ssh server
```angular2html
ssh user@domain.com
```
- Fill-in the username / password that was sent with your welcome package
- Navigate to the 'test' sub-domain (eg test.domain.com) OR you can use any subdomain you like (ensure you create first in the control panel first)
```angular2html
cd ~/www/test
wget https://raw.githubusercontent.com/undoLogic/setupCase-boilerplate/main/build/install_setupCase.sh
chmod +x install_setupCase.sh
./install_setupCase.sh
# Accept the permissions with Y
```

This script will install CakePHP 4 with authentication and integrate the SetupCase library.
You can now test and view the working site: http://test.domain.com/sourceFiles

IMPORTANT: If you get permission issues follow the instructions on the screen to allow the mixed permission directories and then manually commit / push the git files

```angular2html
git add . && git commit -m "Creating new project"
git push -u origin master
```

[back to top](#overview-steps)

### Step 3 Install Software with Chocolatey.org
- Open PowerShell as admin and paste in the install script from  https://chocolatey.org/install
- Run the desired script to install software on your computer
```angular2html
# Install with PowerShell
choco install powertoys -y
choco install libreoffice-fresh -y
choco install phpstorm -y
choco install firefox-dev --pre -y
choco install git -y
choco install openssh --pre -y
choco install opera-developer -y

# Optional 
choco install dropbox -y
choco install tailscale -y
choco install steam -y
choco install nvidia-display-driver -y
choco install microsoft-teams -y
```
[back to top](#overview-steps)
### Step 4 Checkout your new sourceFiles to your local computer
We will now prepare our IDE so we can program locally on our computer but all our files will be auto-uploaded to our server to view the changes
-> Open powershell / terminal

```angular2html
cd ~/PhpstormProjects
# replace with the webAddress from step 2
git clone http://repos.domain.com/project.git projectName
```

The files which you prepared on the server are now on your local computer

[back to top](#overview-steps)
### Step 5 Configure your IDE to automatically push changes to your server

#### 5.1 Setup sFTP on your IDE
- This will allow to upload changes from your computer to your server 

Using PHPstorm:
- Tools -> Deployment -> Browse Remote Host
  - (a side panel will appear) NEXT click '...'
- Name: Test Server (can be anything) 
  - Choose type: sFTP - ssh over FTP
- SSH configuration - click '...'
- Create new config with "+"
  -  HOST: test.domain.com (replace domain with your server domainname)
  - USER: server username (included in your welcome package)
  - AUTHENTICATION TYPE: Key Pair
  - PRIVATE KEY FILE: click folder to navigate to private key
  - PASSPHRASE: Optional
- Click 'Test Connection' to ensure you can connect to the test server

Click OK to return to the previous screen

ROOT PATH: click 'Autodetect'

MAPPINGS (TAB)
- LOCAL PATH: Navigate to your 'sourceFiles' directory
- DEPLOYMENT PATH (During installation): 
  - click to navigate to 'www' -> 'test' (OR the subdomain you created in the control panel) -> 'sourceFiles'
- --- OR ---
- DEPLOYMENT PATH (After project is launched live): 
- click to navigate to 'www' - 'test' (OR the subdomain you created in the control panel)
    - During programming we upload to the root of the subdomain NOT the sourceFiles directory (better for authentication)

#### 5.2 Auto-upload changes
When activated anytime you change a file on your computer it will automatically sFTP that file to the server, allowing you to develop on the server

PHPstorm - Tools - Developement - Options
- UPLOAD CHANGED FILES AUTOMATICALLY TO THE DEFAULT SERVER: "Always"


#### 5.3 TROUBLESHOOTING
If you have issues where your IDE is not uploads the changes to the server follow these steps

Make sure your default upload is selected to the correct profile
- Tools -> Development -> Browse Remote Host (a side panel will appear) NEXT click '...'
- Right click on the correct profile and choose 'Set as Default'

[back to top](#overview-steps)
### Step 6 Testing and watch updates on the test subdomain

Test modifying a file on your computer and see the changes right away on your test server

http://test.domain.com/sourceFiles

[back to top](#overview-steps)
### Step 7 Integrate a professional visual layout to your project

#### 7.1 Download layout source files
Before we start any programming, we first must create our Visual Layout Clickthrough.

Download a layout from your favourite Bootstrap layout supplier. GrayGrids is a great company which you can download beautiful professional layouts to create your visual clickthroughs.

This is a crutial step as it allows you to link together all the visual pages with finalized visuals and add mock-features which outline what programming needs to be completed. You and your team can revise the visuals as much as needed until everything is thought through and approved.

Now you can move on to the programming stage confidently knowing all the programming that will be developed has been throughly brainstormed and this ensures the programming scope won't change after it is started.

#### 7.2 Add Layout Source Files

After you download all the layout source files, save them into "/src/webroot/modules/layoutSourceFiles"

#### 7.3 View in Browser

Because they have been added to webroot, this means you can view the entire layout in your browser
```angular2html
http://test.domain.com/sourceFiles/modules/layoutSourceFiles
```

#### 7.4 Create a new layout file

/src/templates/layout/newLayout.php
Copy all the files from one of the pages from your new layout for example

/src/webroot/modules/layoutSourceFiles/index.html
COPY contents into

/src/templates/layout/newLayout.php

#### 7.5 Create baseLayout variable

All the source files we added to our layout reference files which are located in our modules directory
-> So we are going to simply create a variable the allows us to reference the corrrect location.

In your PagesController.php (or AppController.php) file

```angular2html
function beforeFilter() {
$this->set('baseLayout', Router::url('/').'modules'.DS.'layout'.DS);
}
```

Now in the layout file (/src/templates/newLayout.php)

Find and replace the following:

```angular2html
FIND src=" REPLACEWITH src="<?= $baseLayout; ?>
FIND href=" REPLACEWITH href="<?= $baseLayout; ?>
```

#### 7.6 Separate Layout Content From Each Page Content
We currently have a SINGLE layout file, but we need to create separate pages, so you need to separate the content (on the layout) which is common to all pages apart from the content that is different on each page.

Using inspector find the correct div and cut this content and add to a page

#### 7.7 Create Each Page

Create all the visual pages by doing the following

Create a new function in the controller AND create a new view page

[back to top](#overview-steps)
### Step 8 Programming

#### 8.1 Program with CodeBlocks

We develop with a modular programming process by harnessing standarized blocks of code. 

https://codeblocks.setupcase.com

Search for the specific code fragments in order to convert the finalized visuals into working systems

#### 8.2 Integration with SetupCase Plugin Module
Our solution will give a clear development path: 
- Url based language switching
- Authentication
- MySQL database environments
  - with server based credentials 
  - source files do not store any private credentials
- We are only going to make minor changes to the CakePHP framework core so we have a simple upgrade path in the future

1. open BaseApplication.php (vendor\cakephp\cakephp\src\Http)
```php
//find the function
//public function bootstrap(): void
//Add below: require_once $this->configDir . 'bootstrap.php';
if (file_exists($this->configDir . 'bootstrap-setupCase.php')) {
  require_once $this->configDir . 'bootstrap-setupCase.php';
}
```
2. Then in Application.php add ABOVE the CSRF:
```php
//Added by SetupCase-BoilerPlate
->add(new AuthenticationMiddleware($this->getAuthenticationService()))
->add(new LangMiddleware())
->add(new RbacMiddleware())
->add(new AccessMiddleware())
```

3. And below that function (in Application.php) add this function:
```php
protected function getAuthenticationService() : AuthenticationService {

   //Log::debug('getAuthenticationService');

   $authenticationService = new AuthenticationService([
       'unauthenticatedRedirect' => Router::url('/login'),
       'queryParam' => 'redirect',
   ]);

   // Load identifiers, ensure we check email and password fields
   $authenticationService->loadIdentifier('Authentication.Password', [
       'fields' => [
           'username' => 'email',
           'password' => 'password',
       ]
   ]);

   // Load the authenticators, you want session first
   $authenticationService->loadAuthenticator('Authentication.Session');
   // Configure form data check to pick email and password
   $authenticationService->loadAuthenticator('Authentication.Form', [
       'fields' => [
           'username' => 'email',
           'password' => 'password',
       ],
       'loginUrl' => Router::url('/login'),
   ]);

   return $authenticationService;
}
```

4. AppController->initialize: ADD
```php
$this->loadComponent('Authentication.Authentication');
```

5. Don't forget to import the classes with right click (in PHPstorm)
6. In App_controller / beforeFilter
```php
public function beforeFilter(EventInterface $event) {
    parent::beforeFilter($event); // TODO: Change the autogenerated stub
    $this->setupCase();
}
function setupCase() {
    //RBAC/Access middleware decides if they are allowed in - here we redirect if needed
    $access_granted = $this->request->getAttribute('access_granted');
    if (!$access_granted) {
        $this->Flash->error($this->request->getAttribute('access_msg'));
        $this->redirect($this->referer());
    } else {
        //We handle all RBAC from our RBAC middleware - disable the CakePHP authentication for all pages
        $this->Authentication->addUnauthenticatedActions([$this->request->getAttribute('params')['action']]);
    }
    $this->set('webroot', Router::url('/'));
}
```

7. Src / View Helpers
- AppView.php - add into initalize()
```php
$this->loadHelper('Auth');
$this->loadHelper('Lang');
```



8. Bootstrap.php (add environments)
```php
//Keep this function
if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}
//This will prepare all the correct values for your current environment
$activeEnv = \App\Util\Environments::getActive();
switch($activeEnv) {
    case 'UNDOWEB':
        Configure::load('app_setupCase', 'default');
        break;
    case 'DOCKER':
        Configure::load('app_setupCase', 'default');
        break;
    case 'LOCAL':
        Configure::load('app_local', 'default');
        break;
    default:
        dd('missing environment config file');
}
```

You can duplicate app_setupCase.php to a different environment
- Then add different credentials within your php.ini file 

Credentials
- We harness server based passwords / credentials / api keys, etc
- The source files do NOT contain any secret information ensuring that even if your sourceFiles get leaked, no private connection info will be exposed
- We will store all the private data in the server PHP.ini (GLOBAL) file.

- Ensure you have 2 databases created
```php
# app_setupcase.php
'Datasources' => [
    'default' => [
        'url' => filter_var(env('DATABASE_DEFAULT_URL', get_cfg_var('DATABASE.DEFAULT.URL')), FILTER_VALIDATE_URL),
    ],
    'test' => [
        'url' => filter_var(env('DATABASE_TEST_URL', get_cfg_var('DATABASE.TEST.URL')), FILTER_VALIDATE_URL),
    ],
],
This will first try to load the docker environment vars otherwise will load from the PHP.ini file on the server
# docker-compose.yml
environment:
  DATABASE_URL: mysql://root:undologic@db/LIVE_database
  DATABASE_TEST_URL: mysql://root:undologic@db/automation
# PHP.ini
BOILER.Datasources.default.url = mysql://boilerplate:123@localhost/undoweb_boilerplate_testing
BOILER.Datasources.test.url = mysql://boilerplate:123@localhost/undoweb_boilerplate_test
```

[back to top](#overview-steps)


#### 8.3 Setup Functional Testing

- Testing works on both the server or local using docker
- On Windows setup Ubuntu using WSL2
1. Start Docker on your local computer
2. Login to the docker container
```php
cd PROJECTFILE/docker
./2loginDockerContainer.bat
// you are now inside the docker container
cd /var/www/vhosts/website.com/www/sourceFiles
```
3. Bake the Users Table
```php
bin/cake bake test Table Users
```

4. Bake the fixture
```php
bin/cake bake fixture users
```

5. Run the test
```php
# All
vendor/bin/phpunit
# Controller only (working)
vendor/bin/phpunit tests/TestCase/Controller/PagesControllerTest.php
# Model only (not working)
vendor/bin/phpunit tests/TestCase/Model/Table/UsersTableTest.php
```

#### 8.4 Enhance Security of your site

- Here are some methods to increase the security of your account

1. Change documentRoot 
- On the control panel click "Subdomains"
- Click the pencil next to the subdomain in question
  - If you want to change the LIVE subdomain (it would be 'www', but you can also apply this change to another subdomain)
  - Click the folder and a popup will appear. navigate to 'webroot'
  - After you click 'select' it will return and the 'Document Root' will now be /www/www/webroot
  - Click the checkbox to finalize
- Now your cakePHP files are only exposing the webroot to the public and all the other files are not accessible publically which will increase the security 

2. Change file permissions
- Coming soon...



### Step 9 Launch Changes
Launch allows to efficiently uploads your GITHUB projects to testing, staging and LIVE servers.
Our technology uses basic SSH commands to prepare the source files and does not require extra libraries.

- Run the local script ./1_run.sh
- Launch will logon to your target server (your SSH passphrase adds extra security)
- All the source files from your GitHub account will be exported to the testing and/or staging locations
- You must create a Personal Access Token (in github). This file is NOT stored in your sourcFiles instead it is saved to a PHP.ini file on your server
- This allows you to test and verify all the changes before going LIVE
- After you are satisfied all changes and database changes have been completed you can 'PushLIVE' - which copies all the files to the LIVE location on your target server
- You first need to adjust your 'launch/settings.json' file to match your target servers

```php
# navigate to the launch dir
cd launchPad
./1_run.sh
```

Read the full documentation in the README.md file in the launchPad directory:
https://github.com/undoLogic/setupCase-boilerplate/tree/main/launchPad

[back to top](#overview-steps)
### Step 10 Convert to a dockerized container for VPS deployment
Coming soon...