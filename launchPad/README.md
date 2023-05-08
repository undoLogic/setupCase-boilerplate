# Launch
Launch allows to efficiently uploads your project to testing, staging and LIVE servers. Our technology uses SSH to negotiate the files upload and does not require any extra libraries.
- Run a local script
- Launch will logon to your target server (your SSH passphrase adds extra security)
- All the source files from your GitHub account will be exported to the testing and/or staging locations
- This allows you to test and verify all the changes before going LIVE
- After you are satisfied all changes and database changes have been completed you can 'PushLIVE' - which copies all the files to the LIVE location on your target server
- You first need to adjust your 'launch/settings.json' file to match your target server

### Testing Server
This is an optional server designed to be a URL which you can test that does NOT share the database with the live production server
- Allows to preview new features to clients or colleagues without affecting LIVE production database
- Allow to use for DEV Environment and NOT use Docker (can be faster since Windows is slow for docker). Using SFTP all changed files are uploaded to the testing server automatically.
- Simply access the testing URL and preview your changes
- See below how to [Configure your testing server as your DEV environment](#configure-testing-server-as-dev-environment)

### Staging Server
This is designed to be a URL that shares the database with the LIVE production. 
- This allows to verify all your changes before pushing to LIVE.
- The database can be modified and verified before going LIVE
- Careful as all changes on Staging will be reflected on LIVE
e
## Configuring
Launch needs to be configured for your target server as well as your github account.

1. open the file /launchPad/settings.json and modify all the rows (FIRST-TIME: Rename settings.json.NEW to settings.json - this allows to upgrade and manually update your settings file without overwriting)

TESTING_URL
- Similar to 'STAGING_URL' but for your testing url (Database is separate from LIVE / staging)
```angular2html
"TESTING_URL": "/home/undoweb/www/projectname",
```

TESTING_USER
- Same as 'STAGING_USER' but for testing server
```
"TESTING_USER": "undoweb",
```

TESTING_GIT_ADDRESS:
- This is the full path to your git repo
- If you are launching multiple projects on the same server you need to configure github as github ONLY allows for security a single ssh key per each hostname server
- See below instructions how to create multiple sites configuration file
```angular2html
  "TESTING_GIT_ADDRESS": "https://github.com/undoLogic/setupCase-boilerplate.git",
```

TESTING_ABSOLUTE_PATH
- Same as "STAGING_ABSOLUTE_PATH" above but for testing url
```angular2html
"TESTING_ABSOLUTE_PATH": "/home/undoweb/www/projectname",
```

TESTING_COPY_SRC_TO_ROOT
- copy all the files in the sourceFiles directory to the root of the folder
- false will leave all the files in the sub-folder sourceFiles
- true will copy them all to the root
   - This is important when you deal with authentication and your auth requires the login page be on the root of your sub-domain
```angular2html
  "TESTING_COPY_SRC_TO_ROOT": false
```

STAGING_URL
- This requires you have CREATED a 'Subdomain' on your control panel
- If your subdomain is 'staging' then you would access your site with http://staging.YourDomain.com / http://staging.servername.com
- ONLY add the url WITHOUT 'http://'
```angular2html
"STAGING_URL": "staging.undologic.com",
```

STAGING_USER
- This is the username in your control panel
- Top LEFT in the 'hosting account' box you will see 'Username:'
```
"STAGING_USER": "username",
```

STAGING_GIT_ADDRESS:
- This is the full path to your git repo
- If you are launching multiple projects on the same server you need to configure github as github ONLY allows for security a single ssh key per each hostname server
- See below instructions how to create multiple sites configuration file
```angular2html
  "TESTING_GIT_ADDRESS": "https://github.com/undoLogic/setupCase-boilerplate.git",
```


STAGING_ABSOLUTE_PATH
- This is the path on your server to the location where the source files will be uploaded
- Navigate (on the control panel) to "File Manager" -> "WWW"
- This is the path where you will see the STAGING_URL you created above, click that link
- the Path is located next to 'Location: ' for example "/home/username/www/staging"
```
"STAGING_ABSOLUTE_PATH": "/home/username/www/staging",
```
STAGING_COPY_SRC_TO_ROOT
- copy all the files in the sourceFiles directory to the root of the folder
- false will leave all the files in the sub-folder sourceFiles
- true will copy them all to the root
   - This is important when you deal with authentication and your auth requires the login page be on the root of your sub-domain
```angular2html
  "STAGING_COPY_SRC_TO_ROOT": false
```


LIVE_URL
- Similar to 'STAGING_URL' but for your LIVE production files 
- EXAMPLE: "LIVE_URL": "/home/undologic/www/www"

LIVE_USER
- Same as 'STAGING_USER' but for live server
```
"LIVE_USER": "undologic",
```

LIVE_ABSOLUTE_PATH
- Same as "STAGING_ABSOLUTE_PATH" above but for LIVE
```angular2html
"LIVE_ABSOLUTE_PATH": "/home/undologic/www/www",
```



GITHUB_USER_SLASH_PROJECT
- This is the location where your source files are located on github
- it is your the github username slash project name i.e. undoLogic/projectName
```
"GITHUB_USER_SLASH_PROJECT": "undoLogic/projectName",
```

SRC_FILES_RELATIVE_PATH:
- In your source files this represents where your project files are
- You will have a docker folder which has all the files to manage your docker, you will then have 'launch' which has all the files to configure launch, then you should have 'sourceFiles' which is where your project files are
- Normally this is 'sourceFiles' but if you change you can adjust here where to pull from
- When a project is posted LIVE only the 'sourceFiles' files are posted to the live location
```angular2html
 "SRC_FILES_RELATIVE_PATH": "sourceFiles",
```
BROWSER_LOCAL_PATH_WITH_PROGRAM
- After launch uploads the files it will auto open Firefox to that correct location so you can test
- This currently only works on Windows and does not work on MacOS yet.
```angular2html
    "BROWSER_LOCAL_PATH_WITH_PROGRAM": "C:\\Program Files\\Firefox Developer Edition\\firefox.exe",
```

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
### GITHUB_HOST - Configure multiple projects on the same server

Github does NOT allow (for security) to add mutliple SSH-KEYS to the same server. In order to setup multiple projects on the same server you need to create separate github hostnames to reference each project.
- First create the new private/public file which will be used for this github project and we are specifying the "-f ..." so we won't overright our original key pairs
```
cd ~/.ssh
ssh-keygen -t ed25519 -C "you@email.com" -f id_ed25519_projectName1
chmod 600 id_ed25519_projectName1*
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
        IdentityFile ~/.ssh/id_ed25519_projectName1
Host project2.github.com
        Hostname github.com
        IdentityFile ~/.ssh/id_ed25519_projectName2
```

NOTE: You do NOT need to manually clone, but just so you understand how this works, and if you wanted to manually clone
Launch will automatically do this for you after you change 'GITHUB_HOST' in the launch/settings.json

```angular2html
git clone git@project1.github.com:OWNER/repo-project1.git
# OR
git clone git@project2.github.com:OWNER/repo-project2.git
```

### Configure Testing Server as Dev Environment
Using your TESTING server you are able to create an efficient DEV environment. 
- Locally on your computer you ONLY need PHPstorm open to edit your source files
- PHPstorm will automatically upload all changed files to the testing server ongoing
- Anytime you change any file the same file will be uploaded to the testing server
- As soon as you switch to your browser and view the testing link you will see your new changes
- On Windows Docker can be very slow locally, so this is ideal
1. Open PHPstorm
2. Click 'Tools' -> 'Depoloyment' -> 'Browse Remote Host'
3. Click the '...' to add a new server
4. Name (Add TESTING project) so you will know this is testing
5. Type (choose SFTP: SSH over FTP)
A new window appears
6. SSH configuration: click '...' to create a new ssh config
7. Another new window opens - click 'ADD' to create a new
8. HOST: is the URL of your testing server "projectname.undoweb.com"
9. USERNAME: your assigned username you login to the server with
10. Authentication type:
- Password use the same password you use to login to your testing server
- Keys: If your public key is on the testing server you can use this to authenticate
11. Test connection: click to verify your settings are correct. 
12. Click OK and you will return to the previous window. At this point your SSH connection is setup you now need to assign your project to the testing server
13. Root Path - Click 'autodetect' and the base directory will be determined 
14. Click 'Mappings' tab (top middle tab)
15. Local path - click the folder and browse to the 'sourceFiles'
16. Deployment Path - click the folder and browse to the location of your testing absolute path
17. Top LEFT: click the CHECKMARK on your testing to choose this as the default
18. click OK as you are done setting up
19. Click TOOLS -> DEPLOYMENT -> OPTIONS
20. "Upload changed files automatically to the default server" CHOOSE ALWAYS

#### SUMMARY: 
- At this point you have setup SFTP to allow to upload all your files from the 'sourceFiles' directory to the testing server
- You verified you can connect and ensured the mapping from your local computer to the testing server is correct
- You chose your testing server as the default server
- You enabled auto upload to the default server
- Now any files you change on your local computer will be automaticalliy uploaded to your testing url
