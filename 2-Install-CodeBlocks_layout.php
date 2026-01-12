<?php

if (file_exists('sourceFiles/templates/layout/code_blocks.php')) {
    echo "<br/>Layout already exists — skipping<br/>";
} else {


//////////////////////////////////////////////////////////////////// LAYOUT ///////////////////////
    echo "<h1 style='color: cornflowerblue;'>Setting up Bootstrap Layout</h1>";
    $base = __DIR__ . '/sourceFiles/webroot/';

// Create folders if missing
    $dirs = [
        $base . 'css/',
        $base . 'js/',
        $base . 'icons/'
    ];

    foreach ($dirs as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }

// Files to download (all MIT licensed)
    $files = [
        'css/bootstrap.min.css' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
        'js/bootstrap.bundle.min.js' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
        //'icons/bootstrap-icons.css' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css',
        'icons/fonts/bootstrap-icons.woff' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff',
        'icons/fonts/bootstrap-icons.woff2' => 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/fonts/bootstrap-icons.woff2'
    ];

// Download each file
    foreach ($files as $local => $remote) {
        $target = $base . $local;
        $content = @file_get_contents($remote);
        if ($content !== false) {
            file_put_contents($target, $content);
            echo "✅ Saved: $local\n";
        } else {
            echo "❌ Failed: $remote\n";
        }
    }
/////////////////////////////////////////////////////////// end layout ///////////////////////


}

