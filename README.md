# setupCase-boilerPlate
setupCase.com project base - Manage and launch your project with Docker and Ansible

## A. Installation

### Step 1: Create new Git hub account
Logon to your git hub account and create a new empty project

### Step 2: Clone that account to your computer
Use Php storm (or terminal) to checkout the github files to your computer. You will now have an empty project.

### Step 3: Purchase layout and add source files
Before we start any programming purchase the clients chosen layout and add the raw source
files into the git account, Later the programming will be able to move this into the cakePHP structure.

### Step 4: Add Launch / Docker
You can run a simple command to download the files into your project.
1. Then you can commit into your project separate from this codebase
2. In the future if you want to upgrade to the latest version simply download and overwrite 'roles'. You might need to modify your site.yml
3. Use your terminal and navigate to the base of your project files and run:

#### ALL MODULES (Launch, Docker, libraries, etc)
CAUTION: this will replace 'readme' 'launch' 'docker' if they already exist in your project

```
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/ . --force
```

#### Export ONLY launch (optional)

```
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/launch launch/.
```

#### Export ONLY docker (optional)

```
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/docker docker/.
```

#### Configuring Launch
Launch needs to be configured to pull in the files from Github to your server
1. Logon to your server via SSH
2. First time only - Setup keys - This will create the private / public key in your .ssh directory (do not add a passphase)
```
ssh-keygen -t ed25519 -C "support@undologic.com"
cd ~/.ssh
cat id_ed25519.pub
```
3. Copy and paste the public key into the Deploy keys on github
4. If you want to have multiple projects on the same server you will need to create a ssh config file
```
vi ~/.ssh
# add the following into the file and save
Host project1.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project1.prv
Host project2.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project2.prv
```
5. You will need to rename your private public key as follows
```
mv ~/.ssh/id_ed25519 project1.prv
mv ~/.ssh/id_ed25519.pub project1.pub
```
6. then complete the keygen another time and rename to project2. You can change project1 / project2 to anything you like


#### Export library files only
Included in this boilerplate is basic libraries for handling:
- Switching between languages in your application
- Basic securing your application (this is only meant as the first step and you MUST increase the security later)
- Automated Database interactions

```$xslt
svn export https://github.com/undoLogic/setupCase-boilerPlate/trunk/libraries/cakePHP/2/. libraries/cakePHP/2/. --force
```

### Step 5: Add CakePHP 2.x
You are now ready to add your source files

#### CakePHP 2.x
This downloads the raw project from CakePHP and will place all files into 'src' directory.

### 2.x version
```angular2
svn export https://github.com/cakephp/cakephp/branches/2.x
mv 2.x src 
```

### cleanup
```angular2html
#remove files as they are being added in our root instead
rm src/.gitignore
rm src/.gitattributes
```

#### Import our boilerplate on top of a fresh cakePHP install with standard settings
```angular2
rsync -av libraries/cakePHP/2/. src/app/.
```

#### Cleanup files we will not need as we are creating our own in the base instead
```
rm src/.gitignore
rm src/.gitattributes
```

### Step 6: Startup docker / test project
Look into the docker folder
Right click '2startDocker.sh' OR '3restartDocker.sh'

Navigate to
```angular2
http://localhost/src
```

First time cleanup and preparation
- Fix any errors (src/app/Config/core.php - security salt, etc)
- Uncomment date_default_timezone_set('UTC');
- Ensure gitignore is correct to prevent any large files from being uploaded

### Step 8 gitignore and clean-up
We now want to make sure we only commit/push files that we need to
Ignore tmp folder
-> First delete all folders within (cache/logs)
-> Add an empty file called 'empty'

Add to .gitignore file (root of your project files)
```
/src/app/tmp/cache/*
/src/app/tmp/logs/*
```

Remove the all the files/dirs in app/tmp
- Then add a 'empty' file in app/tmp/empty (This will ensure git saves the directory)
  Ignore cached files
  
## B. Visual Development

### Step 9: Create all your visual pages (concept ONLY)
Build up your navigation and build your site without any database or api connections
- Create all the concept pages in the 'Pages' controller
- Using the display function so you only have to create the ctp pages and you do NOT need to create a controller/action for each page
- Name all your pages in this format: prefix-controller-action.ctp
  eg client_users_edit
  This will only allow (after programming) to limit the logon to 'client' user_types in the Users controller / model using the edit action in the future
  -> This allows to prepare and concept out which pages get the correct prefix in advance.


### Step 10: Organization (files, css, etc)
All folders (elements, css, js, etc) need to have a letter indicating the version.
This letter is also the same as the current layout.
Elements folder should have a directory with the version letter Elements/A/files... Eg webroot/css/A/added-styles.css OR webroot/images/A/image.jpg
-> this ensures if needed to we quickly add on a new module (without creating a new branch, in the same branch) and add new features which do not interfere with the current system at all.
This setup allows to do quick A/B testing by setting which version letter is active in the beforeFilter
Generally we extended a layout and modify per the clients branding. Create a new file 'added-styles-1.css' where the 1 represents a version, and you can quickly change this number to ensure the browsers cache get's reset (without having the client reset it)
CSS organization: Within each CSS file ensure you add loose separations between the sections / pages etc.
-> Eg add a comment at the top to indicate styles for all pages, then create a new comment to indicate styles for a specific page eg /* HOME */

### Step 11: Efficient integration of new scripts
In order to efficiently integrate new modules,
you should store all source files in 'modules/NAME' within the webroot
1. Test that the script works before you integrate into the cakePHP code
2. Create a new page WITHOUT using the layout and ensure the script works (linking all scripts to the modules directory)
3. After you have confirmed it is working in modules and a blank page, next integrate the code into the project using the layout
4. After it is all working if you want you can refactor the scripts

### Step 12: Add Layout
Move the layout from the root (that was added at step 3) and into the cakePHP structure
- WEBROOT/modules/layoutName
  Now integrate into (Views/Layouts/default.ctp)
- Add variable in App_controller in the beforeFilter()
```
$this->set('baseLayout', $this->webroot.'modules'.DS.'layoutName'.DS);
```

Now in your view we need to link to the modules path
-> anywhere you see 'src="assets......' will instead be 'src="<?= $baseLayout; ?>assets......'
-> This also applies to href, url etc

```
<img src="assets/img.jpg"/>
```
will become
```
<img src="<?= $baseLayout; ?>assets/img.jpg"/>
```

IMPORTANT: Make sure you do NOT change href='#' as this will cause problems if you add "....$base; ?>#...."

### Step 12b: Responsive design
Different devices will display the content differently. You need to create media queries to ensure
the layout looks good on all different devices

The devices we target are:
- Mobile: 360 x 640
- Mobile (High quality): 375 x 812  
- Tablet: 768 x 1024
- Laptop: 1366 x 768
- Desktop : 1920 x 1080

Use the following code (in your CSS file) to create different views for the different devices

```angular2html
#Mobile Portrait / Vertical
@media only screen and (max-width: 599px) {
    .cssStyle {
        width: 100%;
    }
}

#Mobile Landscape / Horizontal 
@media only screen and (min-width: 600px) and (max-width: 1199px) {
    .cssStyle {
        width: 100%;
    }
}

#Laptop computer 
@media only screen and (min-width: 1200px) and (max-width: 1500px) {
    .cssStyle {
        width: 100%;
    }
}
#Desktop
@media only screen and (min-width: 1500px) {
    .cssStyle {
        width: 100%;
    }
}
```

Anchor tags need to be offset in certain occasions
```
<a class="anchor" id="top"></a>

#CSS
a.anchor {
    display: block;
    position: relative;
    top: -250px;
    visibility: hidden;
}

```


### Step 13: Approve
Approve all the visual changes with your client BEFORE starting any programming, database development, etc.
Ideas only really start getting figured out when clients are seeing visual working models.
So hold back on programming until the the only feedback you are getting is small changes
which are easy to complete after programming is approved.
Spent time brainstorming with your client and narrow down a very intuitive concept that just feels right.


## C. Programming

### Step 14: Forms
When programming forms, ensure that your action ends up on a dedicated page (controller action)
-> since the validation will make it complicated to validate on your initial page (Usually because there is other content)
-> Use a element to display the form on your initial page, but after you run the form and have validation errors you will end up on a dedicated page.
This page will then be a simplier view (without extra content you had on the intial page)
-> This way the user can continue to enter info until the validation passes and then you redirect to the next action.

### Step 15: Adding functional testing
Allows to setup automated testing to ensure your important functions in your project behave the same before launch.
This allows for rapid development.

DOCKER Init - using PHP 
First login to your docker container 
```
docker exec -it docker_web_1 bash
```

YOU MUST HAVE GIT/ZIP INSTALLED on your docker image

IMPORTANT: This file changes often, so if the hash fails you will need to re-download the most recent here: https://getcomposer.org/download/ (Command-line installation)
```
## This might be out of date so get the updated at: https://getcomposer.org/download/
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('sha384', 'composer-setup.php') === 'c31c1e292ad7be5f49291169c0ac8f683499edddcfd4e42232982d0fd193004208a58ff6f353fde0012d35fdd72bc394') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"

```

After we need to move this to our directory structure

```
mv composer.phar /var/www/vhosts/website.com/www/src/composer.phar
```
NOTE: You will need a git-hub token for the installation process to get all required files and install

Ensure your composer.json file in /src includes (you can remove other attributes if you do not need)
```
"require-dev": {
    "phpunit/phpunit": "^3.7"
},
```

Navigate to the source files 'src' directory (in your docker container)

```
cd /var/www/vhosts/website.com/www/src/
php composer.phar install
```

You should now be able to view the testing framework
```
localhost/src/test.php
```

To Create a TEST: create a file in /src/app/Test/Case/Model/PageTest.php
```
<?php

App::uses('Controller', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ComponentCollection', 'Controller');

class PageTest extends CakeTestCase
{
    //add fixtures later when connecting database models
    public $fixtures = array(
        //'app.Quote',
    );

    function testGetConditionsSearch() {
        $this->assertEquals(1, 1, "This will pass");
        //$this->assertEquals(1, 0, "This will FAIL");
    }
}
```


### Step 16: Bake Models (if required)
The models are created by using BAKE

in the terminal navigate to the base directory of your project

Login to your docker shell

```angular2
cd docker

# find the 'web' to know which container you are using eg docker_web_1
docker ps

docker exec -it docker_web_1 bash

# You are now logged into the docker, now navigate to the project files root (cd path/to/app)
cd /var/www/vhosts/website.com/
cd www
cd app 
./Console/cake bake

```


### Step 17: Programming
Now that all the visuals are approved and all the concepts that need to be programmed have been visualized, the programming should now convert
the visual pages into fully working systems that may interact with a database, external api, etc.

Create most pages with MVC (MODEL-VIEW-CONTROLLER)
-> This is fast to setup and most client actually prefer regular single page loading.

All programming requires a visual representation of the functions in a powerpoint / slides type of document.

However... as soon as any page requires complicated programming immediately implement AngularJS (API style development)
- This will force you to create a solid API structure that will keep your code of good quality moving forward.
- Create a model that will get the data you require from the database
- IMPORTANT: Create a Functional test to get this data from your Model / DB
- Test driven development is not much harder to setup and when it is running future modifications are very easy to implament
- After the functional test is complete then create the controller (API END POINT)
- Use Postman to test getting the data OR use CakePHP Tests (RequestAction)
- Now that you have a solid API you can now integrate this feature into your code with AngularJS

IMPORTANT: You should name all of your functions / methods the exact same between all controllers / models / views. you can prepend words to fit into your
logic, but with the same name you can easily diagnose issues and find references efficiently.

### Step 18: Overview
At this point you have a fully functional docker running with a custom website all that is left is a way to automate the publishing to your Staging / LIVE locations.
Create an automated pipeline
- Each feature is developed in a branch
- On completion the changes are committed / pushed to that branch
- A pull request is created into MASTER
- Manually if MASTER is working a RELEASE is created
- Automated system take the release / test and if success push to LIVE

### Step 19: Logging
Logging needs to HELP support troubleshooting the steps your system is taking.
Ensure your softwre has the following logs for all complex operations
-- Info: should outlines which functions / methods are being accessed and general state
-- Debug: this can have detailed info which can fill the screen that developers use. So you can put a stop point and look at that state to continue development.

Manually view the logs:
```angular2html
## start within your docker docker
cd docker
docker exec -it docker_web_1 bash
## You are now within the docker container
tail -F /var/www/vhosts/website.com/www/src/app/tmp/logs/*.log
## You will now see ALL logs in that directory OR you can log single logs like this
tail -F /var/www/vhosts/website.com/www/src/app/tmp/logs/debug.log
```

### Step 20: Finalizing a project
Leading up to your ALPHA launch the following should be address
- You should have logs that are accessible within the software. This means it is possible to see any issues without viewing linux logs and you can simply login and view the recent activity.
- The most important logs to be first launched are: debug.log (used to develop the software) & info.log (clear messages about what is happening)
- Logs should be used to develop so this forces you to keep them clean and concise.

## D. LAUNCH: Uploading to TESTING / STAGING

### Step 1. Ensure you can connect to the testing / staging server over SSH
Using PHPSTORM right click on the file '1_setupTestingServer.sh'
-> This will attempt to upload your current project to the testing server
-> It will automatically upload the correct branch (or main branch) you are working on to a dedicated URL so a client can test out specific branches before they are merged back into main / master.

#### FIRST TIME ONLY: Prepare SSH private / public keys
Your public SSH key must be assigned to the specific server in order to upload files to it. 
- ensure that your system has a private / public key. Using PHPStorm open Terminal:
```
cd ~/.ssh
ls
```
You SHOULD see 'id_rsa' & 'id_rsa.pub' (these are the private / public keys)
-> If you do NOT see these files 
```
#FIRST TIME ONLY - do not run this command if the file already exists
ssh-keygen -t ed25519 -C "support@undologic.com"
```
Copy&paste this key to your project manager, so they can add you to the testing / staging servers.
```
#this will allow you to copy / paste your key
cat id_ed25519.pub
```
At this point you will be able to logon to a server securely using:
```
ssh user@server.com
```
How-ever we are going to use our commands (within our 'launch' dir), so you will not need to manually type any commands
-> Located in /launch right-click on '1_setupTestingServer.sh'
-> this will attempt to upload your current branch (whether it is master or a specific branch) to the testing server
-> You will be prompted for your passphase (if you added a passphase to your private key)
-> After the files are uploaded a browser will automatically open in your default browser, so you can easily begin testing on the TESTING/STAGING servers. 

When you are approval all changes you can go LIVE by running the following command
-> Right click and run '3_go_LIVE.sh"'
-> This will copy all the files on the staging server to the LIVE server - the project is now LIVE

## E. Troubleshooting

###Line endings were all messed up by a Windows10 machine.
-Logon to the docker machine 
```
docker exec -it docker_web_1 bash
apt-get update
apt-get install dos2unix
find . -type f -print0 | xargs -0 dos2unix
```


## F. Code Snippets

### i. Calculating data with a multi-tiered structure
This allows to efficiently convert a basic array into a multi-tiered array that calculates by custom fields
It is split into 3 separate functions for readability.
- As you need to calculate more values simply add to the 'init' in the prepare function
- then in the groupSales function you can add a single line to calculate
- If you are not structuring with Season, Category, Supplier, you can change i.e. you can instead do Supplier, Season, Category which would allow to total all sales first by the Supplier (opposed to our example first by Season)
- this also allows to set this array to the front-end view and iterate thorugh and simply display the totals (keeping your front-end simple and clean)

```
    function getSales($season_id) {
		$conditions = array('AND' => array(
			array('Sale.season_id' => $season_id),
		));
		$sales = $this->find('all', array(
			'recursive' => -1,
			'contain' => array(),
			'conditions' => $conditions,
		));
		$records = $this->groupSalesByCategory($sales);
		$sales = array(); //clear the original array
		return $records;
	}

	var $salesArray = array();
	function groupSales($sales) {

		foreach ($sales as $saleKey => $sale) {

			$season_id = $sale['Sale']['season_id'];
			$category_id = $sale['Sale']['category_id'];
			$supplier_id = $sale['Sale']['supplier_id'];
			
			$this->prepareSalesArray($season_id, $category_id, $supplier_id);
			
			//calculations
			$this->salesArray['Seasons'][$season_id]['total'] += $sale['Sale']['amount'];
			$this->salesArray['Seasons'][$season_id]['Categories'][$category_id]['total'] += $sale['Sale']['amount'];
			$this->salesArray['Seasons'][$season_id]['Categories'][$category_id]['Suppliers'][$supplier_id]['total'] += $sale['Sale']['amount'];
		}
		
		return $this->salesArray();

	}

	private function prepareSalesArray($season_id, $category_id, $supplier_id) {

		$seasonInit = array('name' => '', 'total' => 0);
		$categoryInit = array('name' => '', 'total' => 0);
		$supplierInit = array('name' => '', 'total' => 0);

		/////SEASONS
		if (!isset($this->salesArray['Seasons'])) {
			$this->salesArray['Seasons'] = array();
		}
		if (!isset($this->salesArray['Seasons'][$season_id])) {
			$this->salesArray['Seasons'][$season_id] = array();
			foreach ($seasonInit as $k => $v) {
				if (!isset( $this->salesArray['Seasons'][$season_id][ $k ] )) {
					$this->salesArray['Seasons'][$season_id][ $k ] = $v;
				}
			}
		}

		///// CATEGORIES
		if (!isset($this->salesArray['Seasons'][$season_id]['Categories'])) {
			$this->salesArray['Seasons'][$season_id]['Categories'] = array();
		}
		if (!isset($this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ])) {
			$this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ] = array();
			foreach ($categoryInit as $k => $v) {
				if (!isset($this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ][ $k ])) {
					$this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ][ $k ] = $v;
				}
			}
		}

		///// SUPPLIERS
		if (!isset($this->salesArray['Seasons'][$season_id]['Categories'][$category_id]['Suppliers'])) {
			$this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ]['Suppliers'] = array();
		}
		if (!isset($this->salesArray['Seasons'][$season_id]['Categories'][$category_id]['Suppliers'][$supplier_id])) {
			$this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ]['Suppliers'][$supplier_id] = array();
			foreach ($supplierInit as $k => $v) {
				if (!isset($this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ]['Suppliers'][$supplier_id][ $k ])) {
					$this->salesArray['Seasons'][$season_id]['Categories'][ $category_id ]['Suppliers'][$supplier_id][ $k ] = $v;
				}
			}
		}
	}

```

### ii. Security - ensure groups do not see wrong data

this function will call up a specific model and ensure that the logged in user is allowed to share the group 
```php

//use - place this into any controller, match the 'Model' and pass in the ID so it can get verifed
$this->ensureCorrectGroup('Model', $this->getGroupId(), $id);

function ensureCorrectGroup($model, $group_id, $id) {
        $testObj = ClassRegistry::init($model, 'Model');
        $found = $testObj->find('first', array(
            'contain' => array(),
            'conditions' => array($model . '.id' => $id)
        ));

        if (!empty($found)) {
            if ($found[$model]['group_id'] == $group_id) {
                return true;
            }
            //some old transactions don't have groups, so we will let this pass
            if ($found[$model]['group_id'] == 0) {
                $this->Session->setFlash('No group assigned: save to add a group');
                return true;
            }
        } else {
            $this->Session->setFlash('Project does not exist in this group');
            $this->redirect('/');
        }
}

	function getGroupId() {

		$user_info = $this->Auth->user();
		//pr($user_info); exit;

		if(isset($user_info['group_id'])){
			return $user_info['group_id'];
		}
		return false;
	}
```


## G. Windows Computer installation

### Use Choco to batch install your Windows10 machine (Reformat, Reinstall)

1. First install Choco: https://chocolatey.org/

2. Next run all these commands at the same time (you can remove or add any software that you use yourself)
```shell
#minimal
choco install docker-desktop -y
choco install dropbox -y
choco install firefox-dev --pre -y
choco install git -y
choco install tailscale -y
choco install openssh --pre -y

#desktop
choco install powertoys -y
choco install libreoffice-fresh -y
choco install phpstorm --pre -y
choco install steam -y
choco install microsoft-teams -y

# programming nodejs
choco install vcredist140 -y
```

manual steps

-- tail-scale - run attended

-- rename PC

-- remote desktop - Start - settings - remote desktop - show settings(first one) - change to allow

-- Finalize WSL2 - click on link in popup and install the WSL2 Linux kernal, then click 'restart' (on the popup)

-- sign-in to firefox (sync extensions including lastpass)

-- connect apps from software -> side bar

-- connect email

-- phpstorm change command prompt (tools - terminal)
``` 
C:\Windows\SysWOW64\WindowsPowerShell\v1.0\powershell.exe
