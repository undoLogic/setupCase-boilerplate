<?php

$CONFIG = dirname(__DIR__) . '/sourceFiles/config/';
$bootstrapFile = $CONFIG . 'bootstrap.php';

if (!file_exists($bootstrapFile)) {
    echo "ERROR - bootstrap.php not found";
    exit;
}

$contents = file_get_contents($bootstrapFile);

// Normalize line endings
$contents = str_replace(["\r\n", "\r"], "\n", $contents);

// Idempotency guard
if (strpos($contents, 'bootstrap-setupCase.php') !== false) {
    echo "bootstrap-setupCase already included — skipping\n";
    exit;
}

// Anchor on the app_local load line
$anchor = "Configure::load('app_local', 'default');";
$pos = strpos($contents, $anchor);

if ($pos === false) {
    echo "ERROR - anchor not found";
    exit;
}

// Find the end of the line
$lineEnd = strpos($contents, "\n", $pos);
$lineEnd = ($lineEnd === false) ? strlen($contents) : $lineEnd + 1;

// Find the closing brace of the if-block
$bracePos = strpos($contents, "}", $lineEnd);
if ($bracePos === false) {
    echo "ERROR - closing brace not found";
    exit;
}

// Move insertion point to AFTER the closing brace + newline
$insertPos = strpos($contents, "\n", $bracePos);
$insertPos = ($insertPos === false) ? $bracePos + 1 : $insertPos + 1;

// Detect indentation (same level as the if)
$lineStart = strrpos(substr($contents, 0, $pos), "\n");
$lineStart = ($lineStart === false) ? 0 : $lineStart + 1;
preg_match('/^\s*/', substr($contents, $lineStart), $m);
$indent = $m[0] ?? '';

// Insert block (no blank line)
$insert =
    $indent . "if (file_exists(\$this->configDir . 'bootstrap-setupCase.php')) {\n" .
    $indent . "    require_once \$this->configDir . 'bootstrap-setupCase.php';\n" .
    $indent . "}\n";

$contents =
    substr($contents, 0, $insertPos) .
    $insert .
    substr($contents, $insertPos);

file_put_contents($bootstrapFile, $contents);

echo "bootstrap-setupCase hook added successfully<br/><br/>";
