# Configuring Launch
Launch needs to be configured to pull in the files from Github to your server
1. Logon to your server via SSH
2. First time only - Setup keys - This will create the private / public key in your .ssh directory (do not add a passphase)
```
ssh-keygen -t ed25519 -C "support@undologic.com"
cd ~/.ssh
cat id_ed25519.pub
```
3. Copy and paste the public key into the 'Deploy keys' on github
   
### multiple projects on the same server 

you will need to create a ssh config file on the target server

```
vi ~/.ssh/config
# add the following into the file and save
Host project1.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project1.prv
Host project2.github.com
        Hostname github.com
        IdentityFile ~/.ssh/project2.prv
```
5. You will need to rename your private & public key to the name you specified in your config file
```
mv ~/.ssh/id_ed25519 project1.prv
mv ~/.ssh/id_ed25519.pub project1.pub
```
6. then complete the keygen another time and rename to project2. You can change project1 / project2 to anything you like

7. Now when you checkout from github you use the following syntax
```angular2html
git clone git@project1.github.com:OWNER/repo-project1.git
# OR
git clone git@project2.github.com:OWNER/repo-project2.git
```