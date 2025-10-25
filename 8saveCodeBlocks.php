<?php
//this will copy the code blocks in sourceFiles back to the code-blocks directory
//This allows to easily save the changes to the version control

echo "<h1 style='color: cornflowerblue;'>Saving CodeBlocks...</h1>";

$dirs = [
    'sourceFiles/src/Controller/CodeBlocksController.php' => 'codeBlocks/cakePHP/4.x/src/Controller/CodeBlocksController.php',
];

foreach ($dirs as $src => $dst) {
    echo "<h2 style='color: cornflowerblue;'>Saving $src to $dst</h2>";
    exec('rsync -av --no-perms --omit-dir-times --fake-super ' . $src . ' ' . $dst, $install);
    echo implode("<br/>", $install);
}
