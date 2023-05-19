<?php
declare(strict_types=1);


use Cake\Core\Configure;

$liveDomains = [
    'staging.connectsec.com',
    'www.connectsec.com',
    'corsi.cyclonetaylor.com',
    'www.sec-reports.com'
];
$currentDomain = $_SERVER['HTTP_HOST'];


if (isset($_SERVER['SERVER_NAME'])) {
    $serverEnv = null;
    switch ($_SERVER['SERVER_NAME']) {
        case 'testboilerplate.undoweb.com':
            Configure::load('app_undoweb', 'default');
            break;
        default:
            die('Missing environment');
    }
}

dd(get_cfg_var('UNDOWEB.EmailTransport.default.password'));
