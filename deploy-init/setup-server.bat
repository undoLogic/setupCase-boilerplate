@echo off

echo Creating init directory...
ssh -4 undoweb@undoweb.com "mkdir -p /home/undoweb/www/codeblocks/deploy-init"

echo Uploading init.php...
scp init.php undoweb@undoweb.com:/home/undoweb/www/codeblocks/deploy-init/init.php

echo Running bootstrap...
ssh -4 undoweb@undoweb.com "cd /home/undoweb/www/codeblocks/deploy-init/ && php init.php"

echo Done.
