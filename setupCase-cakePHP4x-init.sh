#!/bin/bash

# Install Cakephp 4.x
composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles

# Add authentication
composer require "cakephp/authentication:^2.0" -d sourceFiles

# Copy in the SetupCase base files
rsync -av --no-perms --omit-dir-times --fake-super codeBlocks/cakePHP/4.x/. sourceFiles/.