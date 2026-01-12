<?php

$routesFile = __DIR__ . '/sourceFiles/config/routes.php';

$contents = file_get_contents($routesFile);

if (strpos($contents, "prefix('Staff'") !== false) {
    echo "<br/>Staff prefix already exists — skipping<br/>";

} else {

    $insert = <<<'PHP'

    $routes->prefix('Staff', function (RouteBuilder $routes) {

        $routes->connect(
            '/:controller/:action/*',
            []
        );

        $routes->fallbacks(DashedRoute::class);
    });

PHP;

    $needle = <<<PHP
    });
PHP;

    $replacement = <<<PHP
    });
$insert
PHP;

    $count = 0;
    $contents = str_replace($needle, $replacement, $contents, $count);

    if ($count !== 1) {
        throw new RuntimeException("Expected to replace 1 root scope, replaced {$count}");
    }

    file_put_contents($routesFile, $contents);

    echo "Staff prefix added successfully\n";

}
