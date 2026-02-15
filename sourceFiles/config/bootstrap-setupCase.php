<?php
declare(strict_types=1);

use Cake\Core\Configure;

//@todo Change your domains for your project here
$liveDomains = [
    'test.devServer.com' => 'DEV',
    'codeblocks.undoweb.com' => 'UNDOWEB',
    'domain.com' => 'LIVE',
];

$current_domain = $_SERVER['SERVER_NAME'];
if (isset($liveDomains[ $current_domain ])) {
    $current_env_profile = $liveDomains[ $current_domain ];
} else {
    $current_env_profile = false;
}

//@todo
//dd($current_env_profile);
switch($current_env_profile) {
    case 'DEV':
        Configure::load('app_DEV', 'default');
        break;
    case 'UNDOWEB':
        Configure::load('app_undoweb', 'default');
        break;
    default:
        //Unknown so we will use our dev env
        Configure::load('app_DEV', 'default');

}

// Configure the environment setting
Configure::write('App.current_env_profile', $current_env_profile);
