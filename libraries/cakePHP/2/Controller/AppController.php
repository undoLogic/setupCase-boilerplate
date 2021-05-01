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
		'Secure','Session'
	);

	function beforeFilter()
	{
		parent::beforeFilter(); // TODO: Change the autogenerated stub
		$this->Secure->requirePasswordExcept(array(), $_SERVER, $this->Session);

		$this->setupLanguage();
	}


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

    public function writeToLog($filename, $message, $newLine = false) {
        if ($newLine) {
            $message = "\n".date('Ymd-His').' > '.$message;
        } else {
            $message = ' > '.$message;
        }
        file_put_contents(APP.'tmp/logs/'.$filename.'.log', $message, FILE_APPEND);
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

    function jsonHeaders($data) {
        header('Content-Type: application/json');
        echo $data;
        exit;
    }
}
