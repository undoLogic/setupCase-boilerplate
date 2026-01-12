<?php
//this will copy the code blocks in sourceFiles back to the code-blocks directory
//This allows to easily save the changes to the version control

echo "<h1 style='color: cornflowerblue;'>Saving CodeBlocks...</h1>";

$dirs = [
    'sourceFiles/src/Controller/CodeBlocksController.php' => 'codeBlocks/cakePHP/4.x/src/Controller/CodeBlocksController.php',
    'sourceFiles/src/Controller/Staff/CodeBlocksController.php' => 'codeBlocks/cakePHP/4.x/src/Controller/Staff/CodeBlocksController.php',
    'sourceFiles/templates/CodeBlocks/.' => 'codeBlocks/cakePHP/4.x/templates/CodeBlocks',
    'sourceFiles/src/Model/Table/CodeBlocksTable.php' => 'codeBlocks/cakePHP/4.x/src/Model/Table/CodeBlocksTable.php',
    'sourceFiles/templates/element/codeBlocks/.' => 'codeBlocks/cakePHP/4.x/templates/element/codeBlocks',
    'sourceFiles/templates/layout/code_blocks.php' => 'codeBlocks/cakePHP/4.x/templates/layout/code_blocks.php',
    'sourceFiles/src/Util/SetupCase.php' => 'codeBlocks/cakePHP/4.x/src/Util/SetupCase.php',
];

foreach ($dirs as $src => $dst) {
    echo "<h2 style='color: cornflowerblue;'>Saving $src to $dst</h2>";
    exec('rsync -av --no-perms --omit-dir-times --fake-super ' . $src . ' ' . $dst, $install);
    echo implode("<br/>", $install);
}
