# setupCase-boilerPlate Version 4
setupCase.com solution - Build and manage custom software and business websites
with our block programming on our Platform-as-a-service and minimize your local computer 
dependancies.

## Quick Start

1. Initial Setup / Preparation
2. Build a new CakePHP 4 project with our Platform-as-a-service
3. Install software on your local computer with Chocolatey.org
4. Checkout your new sourceFiles to your local computer
5. Configure your IDE to automatically push changes to your server
6. Testing and watch updates on the test subdomain
7. Integrate a professional visual layout to your project
8. Program with our CodeBlocks
9. Launch changes
10. Optional: Migrate to a GitHub Account
11. Optional: Convert to a dockerized container and launch your project on a popular VPS server

### Step 1: Initial Setup / Preparation
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

### Step 2: Build a new CakePHP 4 project with our Platform-as-a-service
- Use powershell / terminal to access the ssh server
```angular2html
ssh user@domain.com
```
- Fill-in the password that was sent with your welcome package
- Navigate to the 'test' sub-domain (eg test.domain.com)
```angular2html
cd ~/www/test
wget https://raw.githubusercontent.com/undoLogic/setupCase-boilerplate/main/build/install_setupCase.sh
chmod +x install_setupCase.sh
./install_setupCase.sh
# Accept the permissions with Y
```

### Step 3: Install Software with Chocolatey.org 
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


## Programming

Add all your database credentials to the PHP.ini file on your server
- This will increase the security of your app and prevent credentials from being stolen from your source files

NOTE: Ensure you remove the php.ini file from your sourcefiles as that will override the parent directory and prevent your source files from getting the credetnaisls

add the following to your global PHP.ini file
```angular2html
PROJECTNAME.Datasources.default.url = mysql://USER:PASS@HOST/DBNAME
```

Then in your source files (app.php - or specific file app_name.php)

```angular2html
    'Datasources' => [
        'default' => [
            'url' => get_cfg_var('PROJECTNAME.Datasources.default.url'),
        ],
....
```

... Partially complete
-> see details here: https://www.setupcase.com/en/Pages/home#install
