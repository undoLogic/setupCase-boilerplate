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
- Activate Git Repo (Control panel -> Git -> fill in form)
- Domain: choose your main domain
- Sub-domain choose 'repos'
- Leave 'web access path' blank'
- Name: use your project name
- Desc: A short desc about your project
- NOTE: Copy down the Web Address, username and password after the Git repo is created for step 4

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

Using PHPstorm:
- Tools -> Development -> Browse Remote Host (a side panel will appear) NEXT click '...'
- Name: test (type: sFTP - ssh over FTP)
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
- DEVELOPMENT PATH (During installation): click to navigate to 'www' -> 'test' (OR the subdomain you created in the control panel) -> 'sourceFiles'
  - OR
- DEVELOPMENT PATH (During Programming): click to navigate to 'www' - 'test' (OR the subdomain you created in the control panel)
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

Use our CodeBlocks to convert your approved visuals into working software.

https://codeblocks.setupcase.com

Search for the specific code fragments in order to convert the finalized visuals into working systems

#### 8.2 Connect MySQL Database

Now we are ready to connect a database to our software application, which will enable us to save data and interact with previously saved data.
- We are only going to make minor changes to the CakePHP framework so we have a simple upgrade path in the future

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
7. Bootstrap (comment out and add environments)
```php
//Keep this function
if (file_exists(CONFIG . 'app_local.php')) {
    Configure::load('app_local', 'default');
}
//This will override the database connection based on environment
$activeEnv = \App\Util\Environments::getActive();
switch($activeEnv) {
    case 'UNDOWEB':
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
- On your server in the PHP.ini (GLOBAL) file you need to add the following:

```angular2html
PROJECTNAME.Datasources.default.url = mysql:/.........
```
which allows to keep all your credentials on the server and NOT in your source files
- get_cfg_var('UNDOWEB.Datasources.default.url')


8. Src / View Helpers
- AppView.php - add into initalize()
```php
$this->loadHelper('Auth');
$this->loadHelper('Lang');
```

[back to top](#overview-steps)





#### 8.3 Setup Functional Testing

- On Windows setup Ubuntu using WSL2
1. Navigate to the base folder within WSL2
```php
cd /mnt/c/Users/USERNAME/PhpstormProjects/PROJECTNAME
```
2. 





### Step 9 Launch Changes

#### 9.1 Configure LaunchPad
First we must configure out settings.json file to connect with our target server.

Follow the detailed instructions on our source code page

Navigate to the 'launchPad' directly.

```angular2html
cd /launchPad
```

#### 9.2 Upload to TESTING (optional)

The test environment is optional and is meant to allow each developer to upload their files to an online server.

This is great to share their progress online and between colleagues.
```angular2html
./1_setupTesting.sh
```

#### 9.3 Upload to STAGING

After all the changes have been completed it is time to post our changes to the LIVE server
-> We first upload our changes to our STAGING server
-> This ensures our project is fully functional, connects properly with any database, etc.
-> This link can be shared with a client who can verify the new version before going LIVE

```angular2html
./2setupStaging.sh
```

#### 9.4 Post LIVE
At this point all the changes have been approved on the staging and we can now confidently push our changes to the LIVE server

```angular2html
./3_go_LIVE.sh
```

[back to top](#overview-steps)
### Step 10 Convert to a dockerized container for VPS deployment
Coming soon...