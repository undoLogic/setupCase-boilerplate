<?php
declare(strict_types=1);

use Cake\Core\Configure;

//@todo Change your domains for your project here
$liveDomains = [
    'test.undoweb.com' => 'UNDOWEB',
    'pending.undoweb.com' => 'PENDING',
    'www.domain.com' => 'LIVE',
];

$current_domain = $_SERVER['SERVER_NAME'];
if (isset($liveDomains[ $current_domain ])) {
    $current_env_profile = $liveDomains[ $current_domain ];
} else {
    die('ERROR: Unknown domain');
}

//@todo
switch($current_env_profile) {
    case 'UNDOWEB':
        Configure::load('app_setupCase', 'default');
        break;
    case 'PENDING':
        Configure::load('app_pending', 'default');
        break;
    case 'LIVE':
        Configure::load('app_LIVE', 'default');
        break;
    default:
        dd('missing environment config file');
}

// Configure the environment setting
Configure::write('App.current_env_profile', $current_env_profile);