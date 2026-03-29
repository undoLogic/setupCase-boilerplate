#!/bin/sh
sudo apt install unzip
curl -L "https://vault.bitwarden.com/download/?app=cli&platform=linux" -o bw.zip
unzip bw.zip
sudo mv bw /usr/local/bin/

bw login


bw config set "enable-ssh-agent" true
bw config enable-ssh-agent true


bw unlock
bw ssh-agent --start


-- the ssh-agent did not work on this method.... will try using linux gui instaed