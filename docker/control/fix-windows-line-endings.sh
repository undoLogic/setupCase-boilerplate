#!/bin/bash
cd /var/www/vhosts/website.com/www && find . -type f -print0 | xargs -0 dos2unix