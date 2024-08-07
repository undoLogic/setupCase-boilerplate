<?php

namespace App\Util;
use Cake\Core\Configure;
use Cake\Mailer\Mailer;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class SetupCase {

    public function getNextThirdThursday($date){

        $thirdThur = $this->getThirdThursday($date);

        if (strtotime($thirdThur) < strtotime($date)) {
            //it's last month, let's get the next month
            $nextMonth = date('Y-m-d', strtotime('+1 month', strtotime($date)));

            $thirdThur = $this->getThirdThursday($nextMonth);
        }

        return $thirdThur;
    }

    public function getThirdThursday($date){

        //$date = '2022-11-29';
        // pr($this->thirdThurs($date)); exit;
        $today = date('l', strtotime($date));


        $first = date('Y-m-01', strtotime("$date"));
        $last = date('Y-m-31', strtotime("$date"));

        $date = $first;
        $count = 0;

        do {

            if(date('l', strtotime($date)) === 'Thursday'){
                $count++;
            }
            if($count == 3){
                return $date;
            }

            $date = date('Y-m-d', strtotime($date. "+1day"));


        } while ($date <= $last);

        return false;

    }

    public static function addToLog($message,$json_data, $user_id, $params)
    {

       FactoryLocator::get('Table')->get('ActivityLogs')->add($message,$json_data, $user_id, $params);

    }// addToLog




    var $liveDomains = [
        //domain => //NAME
    ];

    //environments
    public function env_isLive() {
        $currentDomain = $_SERVER['HTTP_HOST'];

        if (isset($this->liveDomains[ $currentDomain ])) {
            if ($this->liveDomains[ $currentDomain ] == 'LIVE') {
                return true;
            }
        }
        return false;
    }
    public function env_getActive() {
        // allows to define rules how to determine where your software is located
        // you can change this file as you wish

        $currentDomain = $_SERVER['HTTP_HOST'];

        if (isset($this->liveDomains[ $currentDomain ])) {
            return $this->liveDomains[ $currentDomain ];
        } else {
            dd('ERROR: unknown location');
        }

    }






















    public static function isLanguageAllowed($currentLang, $currentWebsite, $websiteLanguages) {
        foreach ($websiteLanguages as $eachWebsite => $langs) {
            if ($currentWebsite == $eachWebsite) {
                if (in_array($currentLang, $langs)) {
                    //this language is allowed
                } else {
                    return false;
                }
            }
        }
        return true;
    }

    public static function getEnglishLink($oldPath) {
        //$oldPath = $this->request->getUri()->getPath();
        return str_replace('es', 'en', $oldPath);
    }


    //is LIVE
    public static function isLIVE($currentDomain, $liveDomains) {
        if (in_array($currentDomain, $liveDomains)) {
            return true;
        }
        return false;
    }



    //SECURE COMPONENT
    var $ths; //$this

    /*
     * When testing is detected in the path, require a basic password to access
     * add to app_controller in beforeFilter
     * $this->Secure->requirePasswordExcept(array('www.website.com', 'website.com'), $_SERVER, $this->Session [,1234]);
     */
    function requirePasswordExcept($exceptions, $server, $session, $password = false) {

        //pr ($exceptions);
        //exit;
        if ($password) {
            //we are using a custom password
            die ('not implented yet');
        } else {

            $passwords = array(
                date('m').date('m'),
                date('m')
            );

            //pr ($server['HTTP_HOST']);

            if (isset($server['HTTP_HOST'])) {

                if (in_array($server['HTTP_HOST'], $exceptions)) {

                    //this is an exception, so let's not enforce a password
                } else {
                    //let's ensure a password

                    if (isset($_GET['login'])) {
                        if ($_GET['login'] == 'logout') {
                            $session->write('TempAccessGiven', 'FALSE');
                            $this->showForm();
                        }
                    }

                    //this is a testing site
                    $isAllowed = $session->read('TempAccessGiven');

                    if ($isAllowed == 'TRUE') {
                        //they are allowed
                    } else {
                        //we need to see if we are allowed.
                        if (isset($_GET['login'])) {
                            if (in_array($_GET['login'], $passwords)) {
                                //they have the right password
                                $session->write('TempAccessGiven', 'TRUE');
                                return 2;

                            } elseif ($_GET['login'] == 'logout') {
                                die ('Logged OUT');
                            } else {
                                die ('NO ACCESS: CODE not correct');
                            }
                        } else {

                            $this->showForm();

                            die ('NO ACCESS: Code Require to access this site');

                        }

                    }


                }
            } else {
                //no http host
            }
        }

    }

    public function requireSSLExcept($exceptions, $ths) {
        $this->ths = $ths;

        if (in_array($_SERVER[ 'SERVER_NAME' ], $exceptions)) {
            //ignore ssl on this host
        } else {
            //if we are NOT ssl activate ssl
            if (!$this->__isSSL()) {
                $this->__redirectSSL();
            } else {
                //already ssl - do nothing
            }
        }
    }

    ////public
    public function forceSSL($ths) {
        $this->ths = $ths;
        if ($this->__isLocal()) {
            return FALSE; //we are local, no ssl
        } elseif (!$this->__isSSL()) {
            $this->__redirectSSL();
        }
    }

    public function forceNoSSL($ths, $path = false) {
        $this->ths = $ths;
        if ($this->__isLocal()) {
            return FALSE; //we are local, no ssl
        } elseif ($this->__isSSL()) {
            $this->__redirectNoSSL($path);
        }
    }

    function __isSSL() {
        if (env('SERVER_PORT') == 443) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function __redirectSSL() {
        $this->ths->redirect('https://' . $this->__url());
    }

    function __redirectNoSSL($path) {
        $this->ths->redirect('http://' . $this->__url($path));
    }

    function __url($path = '') {
        $path = $path ? $path : env('REQUEST_URI');
        return env('SERVER_NAME') . $path;
    }

    function __isLocal() {
        if ($_SERVER[ 'SERVER_NAME' ] == 'localhost') {
            return TRUE;
        }
        return FALSE;
    }

    function assureCorrectSubDomain($ignore, $shouldBe, $ths) {
        if ($this->__isLocal()) {
            return true;//we are local it is ok
        } else {
            if (in_array($_SERVER['HTTP_HOST'], $ignore)) {
                //this domain is ignored
                return true;
            } else {
                if (in_array($_SERVER['HTTP_HOST'], $shouldBe)) {
                    return true;
                } else {
                    //let's redirect
                    $first = reset($shouldBe);
                    $ths->redirect('http://'.$first.'/'.$ths->params->url, 301);
                }
            }
        }
    }

    function showForm() {
        $c = '';
        $c .= '<div style="width: 300px;">';
        $c .= '<form action="" method="GET">';
        $c .= '<input name="login"/>';
        $c .= '</form>';
        $c .= '</div>';
        echo $c;
    }


    public static function sendEmail($to, $template, $from, $subject, $vars, $cc = false, $attachments = [])
    {
        $mailer = new Mailer('default');

        $env = Configure::read('App.current_env_profile');

        if ($env === 'LIVE') {

            dd('Will send LIVE email here');
            $mailer->setTo($to);
            if ($cc) { $mailer->setCc($cc);}
            $mailer->setSubject($subject);
            $mailer->setFrom([$from => 'CUSM']);

        } else {
            dd('testing sending email');

            $mailer->setSubject($subject);
            $mailer->setFrom([$from => 'TESTING Emails']);
            dd('Add your testing email here');
            $mailer->setTo(''); //ADD your testing email here

        }

        $mailer->setEmailFormat('html')
            ->setViewVars($vars)
            ->viewBuilder()
            ->setTemplate($template)
            ->setLayout('default');

        $didSend = $mailer->send();

        return $didSend;

    }


}