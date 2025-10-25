<?php

ini_set('max_execution_time', 300);

// Install CakePHP
echo "<h1 style='color: cornflowerblue;'>Installing CakePHP</h1>";
exec('composer create-project --prefer-dist cakephp/app:~4.0 sourceFiles 2>&1', $create);
echo implode("<br/>", $create);

// Add authentication plugin
echo "<h1 style='color: cornflowerblue;'>Installing authentication</h1>";
exec('composer require "cakephp/authentication:^2.0" -d sourceFiles 2>&1', $auth);
echo implode("<br/>", $auth);
?>