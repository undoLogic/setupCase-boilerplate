<?php

namespace App\Util;
use Cake\Log\Log;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class Environments
{


    public static function isLive(){
        $liveDomains = [
            'staging.connectsec.com',
            'www.connectsec.com',
            'corsi.cyclonetaylor.com',
            'www.sec-reports.com'
        ];
        $currentDomain = $_SERVER['HTTP_HOST'];

        if (in_array($currentDomain, $liveDomains)) {
            return true;
        } else {
            return false;
        }
    }
    public static function getActive() {

        if (isset($_SERVER['HOME'])) {
            if ($_SERVER['HOME'] == '/home/cyclone/') {
                return 'CYCLONE';
            }
        }

       // dd($_SERVER);
        if (isset($_SERVER['SERVER_NAME'])) {
            $serverEnv = null;
            switch ($_SERVER['SERVER_NAME']) {
                case 'localhost':
                    return 'LOCAL';
                    break;
                case 'testsec.undoweb.com':
                    return 'UNDOWEB';
                    break;
                case 'testsec2.undoweb.com':
                    return 'UNDOWEB';
                    break;
                case 'staging.connectsec.com':
                    return 'LIVE';
                    break;
                case 'www.connectsec.com':
                    return 'LIVE';
                    break;
                case 'staging.cyclone.s1256.sureserver.com':
                    return 'CYCLONE';
                    break;
                case 'staging.cyclonetaylor.com':
                    return 'CYCLONE';
                    break;
                case 'corsi.cyclone.s1256.sureserver.com':
                    return 'CYCLONE';
                    break;
                case 'corsi.cyclonetaylor.com':
                    return 'CYCLONE';
                    break;
//                case 'www.sec-reports.com':
//                    return 'CYCLONE';
//                    break;
                default:
                    die('MISSING environment for '.$_SERVER['SERVER_NAME']);
            }
        } else {

            if (isset($_SERVER['HOME'])) {
                if (isset($_SERVER['LOGNAME'])) {
                    if ($_SERVER['LOGNAME'] == 'undoweb') {
                        return 'UNDOWEB';
                    }
                }
            }
            return 'LIVE';
        }

        //dd($_SERVER);



        //backup checks maybe a CLI connection
//        if (isset($_SERVER['LOGNAME'])) {
//            return 'UNDOWEB';
//        } else {
//            //default Cli connection
//           // return 'LOCAL';
//            return 'LIVE';
//        }

    }



}
