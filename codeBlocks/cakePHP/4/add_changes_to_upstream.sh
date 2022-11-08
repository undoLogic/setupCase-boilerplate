#!/bin/bash
SRC_FILES=../../../sourceFiles


rsync -av $SRC_FILES/config/app.php config/app.php
rsync -av $SRC_FILES/config/app_local.php config/app_local.php
rsync -av $SRC_FILES/config/routes.php config/routes.php

# Controllers
rsync -av $SRC_FILES/src/Controller/AppController.php src/Controller/AppController.php
rsync -av $SRC_FILES/src/Controller/SetupPagesController.php src/Controller/SetupPagesController.php
rsync -av $SRC_FILES/src/Controller/Admin/SetupPagesController.php src/Controller/Admin/SetupPagesController.php
rsync -av $SRC_FILES/src/Controller/UsersController.php src/Controller/UsersController.php

# Models
rsync -av $SRC_FILES/src/Model/Entity/User.php src/Model/Entity/User.php
rsync -av $SRC_FILES/src/Model/Table/ObjectStoragesTable.php src/Model/Table/ObjectStoragesTable.php
rsync -av $SRC_FILES/src/Model/Table/UsersTable.php src/Model/Table/UsersTable.php
rsync -av $SRC_FILES/src/Model/Table/UserTypesTable.php src/Model/Table/UserTypesTable.php


# Middleware
rsync -av $SRC_FILES/src/Middleware/*.php src/Middleware/.

# Application
rsync -av $SRC_FILES/src/Application.php src/Application.php


# Templates
rsync -av $SRC_FILES/templates/SetupPages/* templates/SetupPages/.
rsync -av $SRC_FILES/templates/Admin/SetupPages/* templates/Admin/SetupPages/.
rsync -av $SRC_FILES/templates/Users/* templates/Users/.

# emails
rsync -av $SRC_FILES/templates/email/* templates/email/.

# Elements
rsync -av $SRC_FILES/templates/element/*.php templates/element/.

# Views
rsync -av $SRC_FILES/src/View/. src/View/.

# Git add any new files
# git status

git add *

echo "- - - - - - - - New files have been copied and added to git. NEXT: Commit your git changes THEN switch to main branch and compare codeBlocks/cakePHP/4 folders and manually import that new changes THEN commit to main branch"


# echo $SRC_FILES
echo "rsync -av $SRC_FILES/src/Controller/AppController.php sourceFiles/Controller/AppController.php"