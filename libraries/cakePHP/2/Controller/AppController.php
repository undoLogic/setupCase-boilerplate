<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $components = array(
		'Secure','Session',

        //Un-comment to activate the auth
        'Auth' => array(
            'loginAction' => array(
                'user' => false,
                'controller' => 'Users', 'action' => 'login',
            ),
            'authError' => 'Sorry you cannot see this', 'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            ),
            'loginRedirect' => array(
                'controller' => 'users', 'action' => 'index'
            ),
            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
        )
	);

	function beforeFilter()
	{
	    parent::beforeFilter();
		$this->Secure->requirePasswordExcept(array(), $_SERVER, $this->Session);

		$this->setupLanguage();

		//uncheck to use authentication
        //$this->setupAuth();
	}

    function isLiveSite() {
        $liveSites = Configure::read('liveServer');
        if (in_array($_SERVER['HTTP_HOST'], $liveSites)) {
            return true;
        } else {
            return false;
        }
    }

    var $test = array('email' => array(
        'to' => '',
        'from' => '',
        'bcc' => ''
    ));

    function send($to, $vars, $subject, $template = 'main', $cc = false) {

        /*
        //STEP 1 - copy this array into app/Config/email.php
        public $smtp = array(
            'transport' => 'Smtp',
            'from' => array('email@email.com' => 'Testing Email'), //TODO Change-me
            'host' => 'mail.domain.com', //TODO Change-me
            'port' => 587,
            'timeout' => 30,
            'username' => 'email@email.com', //TODO Change-me
            'password' => 'PASSWORD', //TODO Change-me
            'client' => null,
            'log' => false,
            //'charset' => 'utf-8',
            //'headerCharset' => 'utf-8',
        );
        //STEP 2 - place at the top of the App_controller
        //App::uses('CakeEmail', 'Network/Email');
        //STEP 3 - Email layout (you can leave these as is)
        //View/Layouts/emails/html/default
        //View/Layouts/emails/text/default
        //STEP 4 - Email template (you need to create this)
        //View/Emails/html/$TEMPLATE (eg main.ctp - $this->Element('template'))
        //View/Emails/text/$TEMPLATE (eg main.ctp - strip_tags( $this->Element('template') )) This way the TEXT email will not have any HTML elements
        //STEP 5 - Element
        //The element is where the actual data goes with references to $vars etc (the actual content of the email)
        */

        $Email = new CakeEmail();
        $Email->viewVars(array(
            'subject' => $subject,
            'vars' => $vars,
            'domain' => Router::url("/", TRUE)
        ));
        $Email->config('smtp');

        if ($this->isLiveSite()) {
            $Email->to($to);

            //only CC when LIVE
            if (empty($cc)) {
                //no one cc'd
            } else {
                $Email->cc($cc);
            }
            //only BCC when live
            $Email->bcc(array($this->test['email']['bcc']));
        } else {
            $Email->to($this->test['email']['to']);
            $subject = 'TO-EMAIL: '.$to.' - '.$subject;
            //testing do not cc or bcc
            $Email->cc();
            $Email->bcc();
        }


        $from = $this->test['email']['from'];

        $Email->from($from);
        $Email->replyTo($from);

        $Email->subject($subject);
        $Email->emailFormat('both');
        $Email->template($template);

        $sent = $Email->send();

        if ($sent) {
            return TRUE;
        } else {
            die ('could not email ');
            return FALSE;
        }
    }

    public function writeToLog($filename, $message, $newLine = false) {
        if ($newLine) {
            $message = "\n".date('Ymd-His').' > '.$message;
        } else {
            $message = ' > '.$message;
        }
        file_put_contents(APP.'tmp/logs/'.$filename.'.log', $message, FILE_APPEND);
    }

    function jsonHeaders($data) {
        header('Content-Type: application/json');
        echo $data;
        exit;
    }

    //Language
    function setupLanguage()
    {

        $this->Language->setSession($this->Session);

        if (isset($_GET['Lang'])) { $this->Language->setGet($_GET['Lang']); }
        if (isset($this->params['language'])) { $this->Language->setParams($this->params['language']); }
        $this->Language->setDefaultLanguage(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        $currLang = $this->Language->currLang();
        $this->Language->setSessionLang($currLang);
        //pr ($currLang);exit;

        //if no lang is set redirect
        if (!isset($this->params->params['language'])) {
            //die('redirect');
            $this->redirect(array('language' => $currLang));
        }

        Configure::write('currLang', $currLang);

        //switch lang buttons
        $linkEN = 'eng'.DS.$this->request->params['controller'].DS.$this->request->params['action'];
        $linkSP = 'spa'.DS.$this->request->params['controller'].DS.$this->request->params['action'];
        $this->set('switchLinkEN', $linkEN);
        $this->set('switchLinkSP', $linkSP);
        //pr ($this->params);exit;

        $GLOBALS['currLang'] = $currLang;

        switch ($currLang) {
            case 'spa':
                $this->set('langSPA', TRUE);
                $this->set('currLang', $currLang);
                break;
            case 'fre':
                $this->set('langFRE', TRUE);
                $this->set('currLang', $currLang);
                break;
            default:
                $this->set('langENG', TRUE);
                $this->set('currLang', $currLang);
        }
    }
    function setFrench() {
        $this->Language->setCurrLang('fre', $this->Session, $this->Cookie);
    }
    function setEnglish() {
        $this->Language->setCurrLang('eng', $this->Session, $this->Cookie);
        $this->Cookie->write('currLang', 'eng', NULL, '+350 day');
    }
    function currentLang() {
        $currLang = $this->Language->currLang();
        return $currLang;
    }
    function isFrench() {
        $currLang = $this->Language->currLang();
        if ($currLang == 'fre') {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //Authentication
    private function setupAuth() {

        $this->Auth->allow();

        $userInfo = $this->Auth->User();

        if(!empty($userInfo)){
            $this->set('isLoggedIn', true);
            $this->set('userInfo', $this->Auth->user());
            $this->set('group_id', $userInfo['group_id']);
            if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.client')) {
                $this->set('isClient', true);
                $this->set('isModerator', true);
            }else if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.staff')) {
                $this->set('isStaff', true);
                $this->set('isClient', true);
                $this->set('isModerator', true);
            }else if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.admin')) {
                $this->set('isAdmin', true);
                $this->set('isStaff', true);
                $this->set('isClient', true);
            }
        } else {
            $this->set('userInfo', false);
        }
        if (isset($this->params['admin'])) {
            if ($this->params['admin']) {
                $this->forceAdmin();
            }
        }
        if (isset($this->params['staff'])) {
            if ($this->params['staff']) {
                $this->forceStaff();
            }
        }
        if (isset($this->params['client'])) {
            if ($this->params['client']) {
                $this->forceClient();
            }
        }
    }
    function forceClient() {
        if ($this->isAdmin()) {} elseif ($this->isStaff()) {} elseif ($this->isClient()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function forceStaff() {
        if ($this->isAdmin()) {} elseif ($this->isStaff()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function forceAdmin() {
        if ($this->isAdmin()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function isClient() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.client')) { return true; }
        return false;
    }
    function isStaff() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.staff')) { return true; }
        return false;
    }
    function isAdmin() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.admin')) { return true; }
        return false;
    }
    function getUserId() {
        $user_info = $this->Auth->user();
        if(isset($user_info['id'])){ return $user_info['id']; }
        return false;
    }
    function getGroupId() {
        $user_info = $this->Auth->user();
        if(isset($user_info['group_id'])){ return $user_info['group_id']; }
        return false;
    }
    function handleRedirect() {
        $this->redirect('/login');
    }

    //Export to CSV
    function downloadCsv($rows, $filename) {

        $f = fopen('php://memory', 'w');

        $columnNames = array();
        if (!empty($rows)) {
            $firstRow = $rows[0];
            foreach ($firstRow as $colName => $val) {
                $columnNames[] = $colName;
            }
        }

        fputcsv($f, $columnNames);

        foreach ($rows as $rowName => $row) {
            fputcsv($f, $row);
        }
        fseek($f, 0);
        header('Content-Encoding: UTF-8');
        header('Content-type: text/csv; charset=UTF-8');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');
        echo "\xEF\xBB\xBF"; // UTF-8 BOM
        fpassthru($f);
        fclose($f);

        exit;
    }
}
