# setupCase-boilerPlate Version 4
setupCase.com project base - Manage and launch your project with Docker and CakePHP

## Quick Start Instructions

Here is a basic test / quick start guide which shows you how the overall technology stack works.
When complete you will have:
- prepared a new project with the latest CakePHP v4 and docker using powershell / terminal
- integrated it with our SetupCase CodeBlocks
- integrated a free finalized layout into cakePHP V4
- customized the visuals and added new pages
- Verified and modified the responsive design for different mobile devices

###Requirements to run:
- Windows 10 with virtualization activated OR MacOS
- GIT installed (Easy way to install: https://community.chocolatey.org/packages/git OR https://brew.sh/)
- Docker installed (https://www.docker.com/) & Docker-compose
- Powershell / Terminal

Detailed steps are on our website: https://www.setupcase.com/eng/Pages/home#install

Which explain how to: 

Install
- #1 Download SetupCase 
- #2 Startup Docker 
- #3 Verify Docker Running
- #4 Log INTO our Docker Container 
- #5 Install Composer 
- #6 Install CakePHP
- #7 Verified CakePHP is running
- #8 Integrate SetupCase into CakePHP 
- #9 Test screen

Visual Layout Click Through 
- #1 Download Layout Source Files
- #2 Add Layout Source Files to modules directory
- #3 View in browser
- #4 Integrate Layout into cakePHP 
- #5 Create baseLayout variable to connect layout without moving any assets from modules
- Create 'added-styles-A.css' which will override all default styles with branding
- Ensure a class exists around each section so it is easy to target specific sections with the css styles
- Create Real titles and lorum ipsum text
- Create single items and duplicate them with foreach (range(1,3)) as it is best to have one item to modify and have the client approve
- Troubleshooting: 
  - If you have issues copy-and-pasting from the inspect element, copy from the raw html file (some javascript will modify the inspect element tags)
- #6 Separate Layout content from each page content 
- #7 Create each page 



Programming
- #1 CodeBlocks to program
- #2 Refactor, Testing & Verification

Launch
- #1 Configure LaunchPad 
- #2 Upload to TESTING (optional) 
- #3 Upload to STAGING 
- #4 post LIVE 










# Reformat Computer
A workstation is your main setup that you do your majority of work. It should be a desktop, but to each their own. 
Desktop provides the most efficient, non-throttled experience.
- Your workstation's multi-screen layout should be able to be swapped to your secondary (backup computer eg Laptop) 
at a moments notice so you can continue to be efficient even while your main system is down for repair / being reformatted etc. in your comfortable setup.

Reformatting should consist of the following
1. Initial reset process you should be able to do with WITHOUT backing up any files. 
2. Setting up initial programs: Choco, ethernet etc. 
3. Run Choco scripts to re-install all your regular programs (This should be automated)
4. Final manual tweaks. Get this down the a little as possible since this takes the most time

## 1. Initial Reset Process
Windows: Windows button - search for reset this pc

## 2. Setting up initial programs
Windows use Choco
https://chocolatey.org/install
- Use powershell to install

## 3. Automated installation of your main programs using Choco

### All systems
choco install powertoys -y
choco install libreoffice-fresh -y
choco install phpstorm -y
choco install firefox-dev --pre -y
choco install git -y
choco install openssh --pre -y
choco install opera-developer -y

### Specific Systems
choco install docker-desktop -y
choco install dropbox -y
choco install tailscale -y
choco install steam -y
choco install nvidia-display-driver -y
choco install microsoft-teams -y
choco install mysql.workbench -y
choco install googlechrome -y

## 4. Final Manual Tweaks
- Set default browser
- Add Bitwarden to main browser
- Add Raindrop bookmark manager (much more efficient then syncing your browser bookmarks)
- Add SSH keys






