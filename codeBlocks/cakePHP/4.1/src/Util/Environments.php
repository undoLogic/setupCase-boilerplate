<?php

namespace App\Util;

use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class Environments
{

    public static function getActive() {

        // dd($_SERVER);
        if (isset($_SERVER['SERVER_NAME'])) {
            $serverEnv = null;
            switch ($_SERVER['SERVER_NAME']) {
                case 'localhost':
                    return 'LOCAL';
                    break;
                case 'testboilerplate.undoweb.com':
                    return 'UNDOWEB';
                    break;
                default:
                    die('MISSING environment for '.$_SERVER['SERVER_NAME']);
            }
        } else {

            //probably CLI
            if (isset($_SERVER['HOME'])) {
                if (isset($_SERVER['LOGNAME'])) {
                    if ($_SERVER['LOGNAME'] == 'undoweb') {
                        return 'UNDOWEB';
                    }
                }
            } else {
                //default CLI is ?
                return 'LIVE';
            }
        }

    }



}