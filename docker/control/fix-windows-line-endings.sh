#!/bin/bash
cd /var/www/vhosts/website.com/www/sourceFiles/bin && find . -type f -not -path '*/\.git/*' -print0 | xargs -0 dos2unix