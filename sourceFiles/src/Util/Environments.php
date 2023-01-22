<?php

namespace App\Util;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class Environments
{
    public static function isLive(){
        $liveDomains = [
            'boilerplate.undoweb.com'
        ];
        $currentDomain = $_SERVER['HTTP_HOST'];

        if (in_array($currentDomain, $liveDomains)) {
            return true;
        } else {
            return false;
        }
    }
    public static function getActive() {

        //dd($_SERVER);
        if (isset($_SERVER['SERVER_NAME'])) {
            $serverEnv = null;
            switch ($_SERVER['SERVER_NAME']) {
                case 'localhost':
                    return 'LOCAL';
                    break;
                case 'boilerplate.undoweb.com':
                    return 'UNDOWEB';
                    break;
            }
        } else {

            //handle command line stuff here, find a way to detect
            if (isset($_SERVER['HOME'])) {
                if (isset($_SERVER['LOGNAME'])) {
                    if ($_SERVER['LOGNAME'] == 'undoweb') {
                        return 'UNDOWEB';
                    }
                }
            }
            return 'LIVE'; //default command line
        }

        //dd($_SERVER);

    }

}
