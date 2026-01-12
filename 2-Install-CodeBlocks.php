<?php

echo "<h1 style='color: cornflowerblue;'>Installing SetupCase CodeBlocks</h1>";
exec('rsync -av --no-perms --omit-dir-times --fake-super codeBlocks/cakePHP/4.x/. sourceFiles/.', $install);
echo implode("<br/>", $install);

echo "<br/>";

include_once('2-Install-CodeBlocks_layout.php');

include_once('2-Install-CodeBlocks_routes.php');

include_once('2-Install-CodeBlocks_bootstrap.php');
