#!/bin/bash
SRC_FILES=../../../sourceFiles
rsync -av $SRC_FILES/config/app_local.php config/app_local.php
rsync -av $SRC_FILES/config/routes.php config/routes.php

# Controllers
rsync -av $SRC_FILES/sourceFiles/Controller/AppController.php sourceFiles/Controller/AppController.php
rsync -av $SRC_FILES/sourceFiles/Controller/SetupPagesController.php sourceFiles/Controller/SetupPagesController.php
rsync -av $SRC_FILES/sourceFiles/Controller/Admin/SetupPagesController.php sourceFiles/Controller/Admin/SetupPagesController.php
rsync -av $SRC_FILES/sourceFiles/Controller/UsersController.php sourceFiles/Controller/UsersController.php

# Models
rsync -av $SRC_FILES/sourceFiles/Model/Entity/User.php sourceFiles/Model/Entity/User.php
rsync -av $SRC_FILES/sourceFiles/Model/Table/ObjectStoragesTable.php sourceFiles/Model/Table/ObjectStoragesTable.php
rsync -av $SRC_FILES/sourceFiles/Model/Table/UsersTable.php sourceFiles/Model/Table/UsersTable.php
rsync -av $SRC_FILES/sourceFiles/Model/Table/UserTypesTable.php sourceFiles/Model/Table/UserTypesTable.php

# Templates
rsync -av $SRC_FILES/templates/SetupPages/* templates/SetupPages/.
rsync -av $SRC_FILES/templates/Admin/SetupPages/* templates/Admin/SetupPages/.
rsync -av $SRC_FILES/templates/Users/* templates/Users/.

# Elements
rsync -av $SRC_FILES/templates/element/*.php templates/element/.

# Git add any new files
# git status

git add *

echo "- - - - - - - - New files have been copied and added to git. NEXT: Commit your git changes THEN switch to main branch and compare libraries/cakePHP/4 folders and manually import that new changes THEN commit to main branch"