<?php

$routesFile = dirname(__DIR__) . '/sourceFiles/config/routes.php';

if (!file_exists($routesFile)) {
    echo "ERROR - routes.php not found";
    exit;
}

$contents = file_get_contents($routesFile);

if ($contents === false) {
    echo "ERROR - Could not read routes.php";
    exit;
}

$contents = str_replace(["\r\n", "\r"], "\n", $contents);
$updated = false;

$rootRoutes = <<<'PHP'
        $builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);
        $builder->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
        $builder->connect('/beginReset', ['controller' => 'Users', 'action' => 'beginReset']);
        $builder->connect('/reset', ['controller' => 'Users', 'action' => 'reset']);

        // language
        $builder->connect('/{language}', ['controller' => 'Pages', 'action' => 'home'], ['language' => 'en|fr|es']);
        $builder->connect('/{language}/{controller}/{action}/*', [], ['language' => 'en|fr|es']);
        $builder->connect('/{language}/{controller}', ['action' => 'index'], ['language' => 'en|fr|es']);

        //redirect for older langs
        //$builder->connect('/eng', ['controller' => 'Pages', 'action' => 'home'], ['language' => 'en|fr|es']);
        //$builder->connect('/fre', ['controller' => 'Pages', 'action' => 'home'], ['language' => 'en|fr|es']);
        //$builder->connect('/eng/{controller}/{action}/*', ['language' => 'eng', 'controller' => 'Pages', 'action' => 'redirect'], ['language' => 'en|fr|es']);
        //$builder->connect('/fre/{controller}/{action}/*', [], ['language' => 'en|fr|es']);
        //$builder->connect('/eng/{controller}', ['action' => 'index'], ['language' => 'en|fr|es']);
        //$builder->connect('/fre/{controller}', ['action' => 'index'], ['language' => 'en|fr|es']);

PHP;

if (strpos($contents, "\$builder->connect('/login', ['controller' => 'Users', 'action' => 'login']);") === false) {
    $needle = "        \$builder->fallbacks();\n";
    $contents = str_replace($needle, $rootRoutes . $needle, $contents, $count);
    if ($count !== 1) {
        echo "ERROR - root scope fallback anchor not found";
        exit;
    }
    $updated = true;
}

$oldStaffBlock = <<<'PHP'
    $routes->prefix('Staff', function (RouteBuilder $routes) {

        $routes->connect(
            '/:controller/:action/*',
            []
        );

        $routes->fallbacks(DashedRoute::class);
    });
    
PHP;

$oldManagerBlock = <<<'PHP'
    $routes->prefix('Manager', function (RouteBuilder $routes) {

        $routes->connect(
            '/:controller/:action/*',
            []
        );

        $routes->fallbacks(DashedRoute::class);
    });
    
    
    

PHP;

if (strpos($contents, "prefix('Staff'") !== false) {
    $contents = str_replace($oldStaffBlock, '', $contents, $count);
    if ($count > 0) {
        $updated = true;
    }
}

if (strpos($contents, "prefix('Manager'") !== false) {
    $contents = str_replace($oldManagerBlock, '', $contents, $count);
    if ($count > 0) {
        $updated = true;
    }
}

$prefixBlocks = <<<'PHP'

    $routes->prefix('staff', function (RouteBuilder $routes) {

        //with the lang
        $routes->connect('/:language/:controller/:action/*', [])->setPatterns(['language' => 'en|fr|es']);

        $routes->fallbacks(DashedRoute::class);
    });

    $routes->prefix('admin', function (RouteBuilder $routes) {

        //with the lang
        $routes->connect('/:language/:controller/:action/*', [])->setPatterns(['language' => 'en|fr|es']);

        $routes->fallbacks(DashedRoute::class);
    });

PHP;

if (strpos($contents, "prefix('staff'") === false || strpos($contents, "prefix('admin'") === false) {
    $needle = "\n\n    /*\n     * If you need a different set of middleware or none at all,\n";
    $contents = str_replace($needle, $prefixBlocks . $needle, $contents, $count);
    if ($count !== 1) {
        echo "ERROR - API comment anchor not found for prefix blocks";
        exit;
    }
    $updated = true;
}

if (!$updated) {
    echo "Routes setup already exists — skipping<br/>";
    exit;
}

file_put_contents($routesFile, $contents);

echo "Routes setup added successfully<br/><br/>";
