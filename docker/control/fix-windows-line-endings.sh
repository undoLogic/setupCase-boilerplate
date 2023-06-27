#!/bin/bash
# you should only need to clean this directory
cd /var/www/vhosts/website.com/www/sourceFiles/vendor/bin && find . -type f -not -path '*/\.git/*' -print0 | xargs -0 dos2unix