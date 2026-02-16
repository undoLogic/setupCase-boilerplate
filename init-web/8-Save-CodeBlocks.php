<?php
//this will copy the code blocks in sourceFiles back to the code-blocks directory
//This allows to easily save the changes to the version control

echo "<h1 style='color: cornflowerblue;'>Saving CodeBlocks...</h1>";

$rootDir = dirname(__DIR__);

$dirs = [
    //Controllers
    $rootDir . '/sourceFiles/src/Controller/CodeBlocksController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/CodeBlocksController.php',
    $rootDir . '/sourceFiles/src/Controller/EmailQueuesController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/EmailQueuesController.php',
    $rootDir . '/sourceFiles/src/Controller/Staff/CodeBlocksController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/Staff/CodeBlocksController.php',
    $rootDir . '/sourceFiles/src/Controller/Staff/EmailQueuesController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/Staff/EmailQueuesController.php',
    $rootDir . '/sourceFiles/src/Controller/Staff/AuditLogsController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/Staff/AuditLogsController.php',
    $rootDir . '/sourceFiles/src/Controller/Manager/CodeBlocksController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/Manager/CodeBlocksController.php',
    $rootDir . '/sourceFiles/src/Controller/Manager/EmailQueuesController.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Controller/Manager/EmailQueuesController.php',

    //Templates
    $rootDir . '/sourceFiles/templates/CodeBlocks/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/CodeBlocks',
    $rootDir . '/sourceFiles/templates/EmailQueues/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/EmailQueues',
    $rootDir . '/sourceFiles/templates/Staff/CodeBlocks/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/Staff/CodeBlocks',
    $rootDir . '/sourceFiles/templates/Staff/EmailQueues/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/Staff/EmailQueues',
    $rootDir . '/sourceFiles/templates/Staff/AuditLogs/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/Staff/AuditLogs',
    $rootDir . '/sourceFiles/templates/Manager/CodeBlocks/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/Manager/CodeBlocks',

    //Models
    $rootDir . '/sourceFiles/src/Model/Table/CodeBlocksTable.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Model/Table/CodeBlocksTable.php',
    $rootDir . '/sourceFiles/src/Model/Table/AuditLogsTable.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Model/Table/AuditLogsTable.php',
    $rootDir . '/sourceFiles/src/Model/Table/EmailQueuesTable.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Model/Table/EmailQueuesTable.php',
    $rootDir . '/sourceFiles/src/Model/Table/EmailQueueAttachmentsTable.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Model/Table/EmailQueueAttachmentsTable.php',
    $rootDir . '/sourceFiles/src/Model/Behavior/.' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Model/Behavior',

    //elements
    $rootDir . '/sourceFiles/templates/element/codeBlocks/.' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/element/codeBlocks',

    //Layouts
    $rootDir . '/sourceFiles/templates/layout/code_blocks.php' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/layout/code_blocks.php',
    $rootDir . '/sourceFiles/templates/email/html/email_queues.php' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/email/html/email_queues.php',
    $rootDir . '/sourceFiles/templates/email/text/email_queues.php' => $rootDir . '/codeBlocks/cakePHP/4.x/templates/email/text/email_queues.php',

    //Util
    $rootDir . '/sourceFiles/src/Util/AuditContext.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Util/AuditContext.php',
    $rootDir . '/sourceFiles/src/Util/SetupCase.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/Util/SetupCase.php',

    //View helpers
    $rootDir . '/sourceFiles/src/View/Helper/MenuStateHelper.php' => $rootDir . '/codeBlocks/cakePHP/4.x/src/View/Helper/MenuStateHelper.php',
];

foreach ($dirs as $src => $dst) {
    echo "<h2 style='color: cornflowerblue;'>Saving " . htmlspecialchars($src) . " to " . htmlspecialchars($dst) . "</h2>";
    $install = [];
    exec(
        'rsync -av --no-perms --omit-dir-times --fake-super ' .
        escapeshellarg($src) . ' ' . escapeshellarg($dst),
        $install
    );
    echo implode("<br/>", $install);
}
