# Launch
Launch allows to efficiently uploads your project to testing, staging and LIVE servers. Our technology uses SSH to negotiate the files upload.

- Run a local script
- Launch will logon to your target server
- All the source files from your GitHub account will be exported to the testing and/or staging locations
- This allows you to test and verify all the changes before going LIVE
- After you are satisfied all changes and database changes have been completed you can 'PushLIVE' - which copies all the files to the LIVE location on your target server
- You first need to adjust your 'launch/settings.json' file to match your target server

## Configuring
Launch needs to be configured for your target server as well as your github account.

**NOTE: Normally you ONLY need STAGING and LIVE since they share the same database, TESTING is optional**

FIRST-TIME: Rename settings.json.NEW to settings.json
-> this allows to upgrade and manually update your settings file without overwriting

1. open the file /launchPad/settings.json and modify all the rows

STAGING_URL
- This requires you have CREATED a 'Subdomain' on your control panel
- If your subdomain is 'test' then you would access your site with http://test.YourDomain.com
- ONLY add the url WITHOUT http://
- This row would be:

    "STAGING_URL": "appsites.undologic.com",

STAGING_USER
- This is the username in your control panel
- Top LEFT in the 'hosting account' box you will see 'Username:'

    "STAGING_USER": "username",

STAGING_ABSOLUTE_PATH
- This is the path on your server to the location where the source files will be uploaded
- Navigate (on the control panel) to "File Manager" -> "WWW"
- This is the path where you will see the TESTING_URL you created above, click that link
- the Path is located next to 'Location: ' for example "/home/username/www/test"

    "STAGING_ABSOLUTE_PATH": "/home/username/www/test"

#### STAGING AND LIVE
_Staging is meant to share the same database as your LIVE server, which allows you to verify changes before going live and to correct the database if you have made any changes.
LIVE is your live server which is accessed to your target users. Modify all the _URL, _USER, _ABSOLUTE_PATH as your staging and live server settings are setup_

GITHUB_USER_SLASH_PROJECT
- This is the location where your source files are located on github
- it is your the github username slash project name i.e. undoLogic/projectName

    "GITHUB_USER_SLASH_PROJECT": "undoLogic/projectName"

GITHUB_HOST:
- By default this is github.com
- If you are launching multiple projects on the same server you need to configure github as github ONLY allows a single ssh key per each hostname server
- See below instructions how to create multiple sites configuration file

SRC_FILES_RELATIVE_PATH:
- In your source files this represents where your project files are
- You will have a docker folder which has all the files to manage your docker, you will then have 'launch' which has all the files to configure launch, then you should have 'src' which is where your project files are
- Normally this is 'src' but if you change you can adjust here where to pull from
- When a project is posted LIVE only the 'src' files are posted to the live location

BROWSER_LOCAL_PATH_WITH_PROGRAM
- After launch uploads the files it will auto open Firefox to that correct location so you can test
- This currently only works on Windows and does not work on MacOS yet.

    "BROWSER_LOCAL_PATH_WITH_PROGRAM": "C:\\Program Files\\Firefox Developer Edition\\firefox.exe",

### Setup SSH keys
To allow to export the GitHub source files to the server we must setup a public / private key. the PRIVATE key is ONLY on the server. the PUBLIC key goes onto Github -> deploy keys

1. Logon to your server via SSH using the STAGING credentials
   
NOTE: New servers you need to put your PUBLIC SSH KEY into the Control panel -> ssh keys -> import ssh key
   ssh STAGING_USER @ STAGING_URL
```angular2html
ssh undologic@staging.undologic.com
```

2. First time only - Setup keys - This will create the private / public key (*.pub) in your .ssh directory (do NOT add a passphase).
```
cd ~/.ssh
ssh-keygen -t ed25519 -C "you@email.com"
cat id_ed25519.pub
```
3. Copy and paste the public key (ends with .pub) into the 'Deploy keys' on github.com (in your project)

4. You are now ready to run the LAUNCH script

IMPORTANT: The first time you need to manually run the script as it will require you confirm YES to the authenticity. When you run the script copy and paste the script manully into your favourite ssh program
```
cd launch
./2_setupStagingServer.sh
```
### Configure multiple projects on the same server

Github does NOT allow (for security) to add mutliple SSH-KEYS to the same server. In order to setup multiple projects on the same server you need to create separate github hostnames to reference each project.
- First create the new private/public file which will be used for this github project and rename it to the project name
```
cd ~/.ssh
ssh-keygen -t ed25519 -C "you@email.com"
mv id_ed25519 project1.prv
mv id_ed25519.pub project1.pub
```

- Now create or edit your ssh config file
```
  vi ~/.ssh/config
```
- Add your new public (ends with .PUB) you created above into the ssh config file
- Ensure the GITHUB_HOST matches the Host line (Hostname is ALWAYS github.com)
- project1 can be any name to represent your project

```
Host project1.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project1.prv
Host project2.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project2.prv
```

NOTE: You do NOT need to manually clone, but just so you understand how this works, and if you wanted to manually clone
Launch will automatically do this for you after you change 'GITHUB_HOST' in the launch/settings.json

```angular2html
git clone git@project1.github.com:OWNER/repo-project1.git
# OR
git clone git@project2.github.com:OWNER/repo-project2.git
```
