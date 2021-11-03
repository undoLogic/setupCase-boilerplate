<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link https://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

	var $modelUsed = 'User';

	function logout() {
		$this->Session->write('token', 0);
		die ('logged out');
	}

//    private function emailReminder($to, $hash)
//    {
//
//        //pr ($to);
//        //pr ($hash);
//        //exit;
//
//        $domain = Router::url("/", TRUE);
//
//        $this->set('hash', $hash);
//        $this->set('domain', $domain);
//
//        $subject = 'Password Reset';
//
//        $Email = new CakeEmail();
//
//        //not working
//        //$Email->transport('smtp');
//
//        $Email->to($to);
//
//        $vars['hash'] = $hash;
//        $vars['domain'] = $domain;
//        $Email->viewVars($vars);
//
//        //$this->Email->lineLength = 200;
//        $Email->subject($subject);
//        $Email->from('info@undologic.com');
//
//        $Email->template('reset');
//        //$this->Email->layout = 'reset';
//        $Email->emailFormat('html');
//
//        //$this->Email->template = null;
//        //old method
//        //'Reset your password here.' . Router::url("/", true) . 'system/tickets/reset/' . $hash
//        $sent = $Email->send();
//
//        if ($sent) {
//            return TRUE;
//        } else {
//            return FALSE;
//        }
//    }

	function login() {
		//pr($this->Auth->password('acs333')); exit;

		$this->set('login', true);

		if ($this->request->is('post')) {

            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirectUrl());
            } else {
                $this->Session->setFlash(
                    $this->updateCase->Translate('Username or password is incorrect'),
                    'default',
                    array(),
                    'auth'
                );
            }

		} else {
			// before login /register. create random number for human check



		}
	}

	function home() {

	}

	//used with AngularJS to ensure we are still logged in
    function isLoggedIn() {
        $userInfo = $this->Auth->user();
        if (empty($userInfo)) {
            die ('440 Login Time-out');
        } else {
            die ('200 Logged In');
        }

        exit;
    }

    function forgot($key = FALSE) {
        $this->set('section_admin', NULL);
        if (!empty($this->data)) {
            if ($userInfo = $this->User->doesUserExist($this->data['User']['email'])) {

                //we have a user let's write a ticket
                $hash = $this->User->Ticket->generate($userInfo['User']['id']);

                //Let's create an email with the hash
                $vars['hash'] = $hash;
                $subject = 'Password Reset';

                if ($this->send( $userInfo['User']['email'], $vars, $subject, 'reset' )) {
                    $this->Session->setFlash('Email sent. Please check your email to reset your password');
                } else {
                    $this->Session->setFlash('Error; Please call customer service');
                }
            } else {
                $this->Session->setFlash("No email exists");
            }
        }
    }

}
