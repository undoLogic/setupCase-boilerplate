<?php

$rootDir = dirname(__DIR__);
$codeBlocksDir = $rootDir . '/codeBlocks/cakePHP/4.x/.';
$sourceFilesDir = $rootDir . '/sourceFiles/.';

if (!is_dir($rootDir . '/sourceFiles')) {
    echo "<h1 style='color: #b00020;'>sourceFiles does not exist</h1>";
    echo "Run init-web/1-Install-Cake.php first.<br/>";
    exit(1);
}

echo "<h1 style='color: cornflowerblue;'>Installing SetupCase CodeBlocks</h1>";
exec(
    'rsync -av --no-perms --omit-dir-times --fake-super ' .
    escapeshellarg($codeBlocksDir) . ' ' . escapeshellarg($sourceFilesDir),
    $install
);
echo implode("<br/>", $install);

echo "<br/>";

include_once(__DIR__ . '/9-Install-CodeBlocks_layout.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_routes.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_bootstrap.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_application.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_middleware.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_appController.php');

include_once(__DIR__ . '/9-Install-CodeBlocks_helpers.php');
