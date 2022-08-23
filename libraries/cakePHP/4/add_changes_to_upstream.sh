#!/bin/bash
SRC_FILES=../../../src
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