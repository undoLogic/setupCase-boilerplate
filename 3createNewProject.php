<?php

echo "<h1 style='color: cornflowerblue;'>Preparing sourcefiles for a new project (Removing all connections to SetupCase)</h1>";

// Delete all .git files/folders inside sourceFiles and root
exec('rm -rf sourceFiles/.git* 2>&1', $out1);
exec('rm -rf .git* 2>&1', $out2);

// Delete the old README file if it exists
exec('rm -f README 2>&1', $out3);

// Create a new README file with custom content
$readmeContent = <<<EOL
# New README
This is a new project
EOL;

// Use echo + redirect to create the file
exec('echo ' . escapeshellarg($readmeContent) . ' > README 2>&1', $out4);

// Output all results
echo implode("<br>", array_merge($out1, $out2, $out3, $out4));
echo "<br>✔ README recreated successfully.";

