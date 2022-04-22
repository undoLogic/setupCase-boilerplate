<?php
$baseDir = dirname(dirname(__FILE__));

return [
    'plugins' => [
        'ADmad/I18n' => $baseDir . '/vendor/admad/cakephp-i18n/',
        'Authentication' => $baseDir . '/vendor/cakephp/authentication/',
        'Bake' => $baseDir . '/vendor/cakephp/bake/',
        'Cake/TwigView' => $baseDir . '/vendor/cakephp/twig-view/',
        'DebugKit' => $baseDir . '/vendor/cakephp/debug_kit/',
        'Migrations' => $baseDir . '/vendor/cakephp/migrations/',
    ],
];
