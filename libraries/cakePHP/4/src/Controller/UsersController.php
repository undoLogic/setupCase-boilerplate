<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use Cake\Routing\Router;
use Authentication\PasswordHasher\DefaultPasswordHasher;

// Add this line


/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);


    }

//    function testing()
//    {
//
//        $email = 'sachalewis@undologic.com';
//        $pass = '1234';
//
//        $passObj = new DefaultPasswordHasher;
//
//        $hash = ($passObj)->hash($pass);
//
//        $this->writeToLog('debug', 'pass is: ' . $pass, true);
//        $this->writeToLog('debug', 'hash is: ' . $hash, true);
//        $isCorrect = $passObj->check($pass, $hash);
//        $this->writeToLog('debug', 'isCorrect: ' . $isCorrect, true);
//
//
//        $didSave = $this->Users->saveUserPassword($email, $hash);
//        $this->writeToLog('debug', 'didSave: '.$didSave, true);
//
//
//        $userArray = $this->Users->getUserByEmail($email);
//        pr ($userArray);
//
//
//        $session = $this->request->getSession();
//        $session->write('User', $userArray);
//
//        $sessionUser = $session->read('User');
//
//        pr ($sessionUser);
//
//
//        exit;
//
//    }


    function signup() {

        if ($this->request->is('post')) {

            $this->writeToLog('debug', 'Signup', true);

            $emailSubmitted = $this->request->getData()['email'];
            $passSubmitted = $this->request->getData()['password'];

            $passObj = new DefaultPasswordHasher;
            $didCreateUser = $this->Users->createUser(
                $emailSubmitted,
                $passObj->hash($passSubmitted)
            );

            if ($didCreateUser) {
                $this->writeToLog('debug', 'User created user_id: '.$didCreateUser['id'], false);
                $this->Flash->success('User has been CREATED');

                $session = $this->request->getSession();
                $session->write('User', $didCreateUser);

                return $this->redirect(array('prefix' => 'Admin', 'controller' => 'SetupPages', 'action' => 'home'));
            } else {
                $this->Flash->error('Could NOT create user');
                return $this->redirect('/');
            }

        }

    }

    function login()
    {
        if ($this->request->is('post')) {

            $this->writeToLog('debug', 'Login', true);

            $emailSubmitted = $this->request->getData()['email'];
            $passObj = new DefaultPasswordHasher;
            $userArray = $this->Users->getUserByEmail(
                $emailSubmitted
            );

            if (!empty($userArray)) {
                $this->writeToLog('debug', 'Found user: '.$userArray['email'], false);
                $passSubmitted =  $this->request->getData()['password'];
                $isCorrect = $passObj->check($passSubmitted, $userArray['password']);
                if ($isCorrect) {
                    //password is correct
                    $session = $this->request->getSession();
                    $session->write('User', $userArray);
                    //pr($session->read('User')); exit;
                    $this->writeToLog('debug', ' - Password is correct');
                    $this->Flash->success('Login Success');
                    return $this->redirect(array('prefix' => 'Admin', 'controller' => 'SetupPages', 'action' => 'home'));

                } else {
                    $this->writeToLog('debug', ' - WRONG Password');
                    $this->Flash->error('Password is INCORRECT');
                }
            } else {
                $this->writeToLog('debug', ' - '.$emailSubmitted.' does NOT exist');
                $this->Flash->error('Problem logging you in. Please check your email and password and try again');
            }
        }

    }//login

    function logout()
    {
        $this->writeToLog('debug', 'Logout');

        //remove the session which was holding the user object
        $session = $this->request->getSession();
        $session->write('User', false);

        //redirect to the home page
        $this->redirect('/');
    }

    function beginReset()
    {
        $this->writeToLog('debug', 'BeginReset', true);

        //accept an email from a post form
        if ($this->request->is('post')) {
            //if the email exists -> there should be a new column in the users table 'reset_token' get a random text string 8 alpha characters and add that into the users database
            $emailSubmitted = $this->request->getData()['email'];
            $userExists = $this->Users->getUserByEmail($emailSubmitted);
            if ($userExists) {
                //that user does exist
                $userToken = $this->Users->resetAddToken($emailSubmitted);
                //pr ($userToken);
                $this->writeToLog('debug', '- token: '.$userToken['reset_token'], false);

                echo 'This link will be sent in an email | '.Router::url('/').'Users'.DS.'reset'.DS.$emailSubmitted.DS.$userToken['reset_token'];
                exit;

            } else {
                //does not exist
                $this->writeToLog('debug', 'That email does NOT exist: '.$emailSubmitted, false);
            }
        } else {
            //start
        }
    }

    function reset($email = false, $resetToken = false)
    {
        $this->writeToLog('debug', 'Reset', true);
        if ($this->request->is('post')) {
            $this->writeToLog('debug', 'POST');
            $user = $this->Users->getUserByEmailAndResetToken($email, $resetToken);
            if (!empty($user)) {
                //email and token are still ok
                $newPassword = $this->request->getData()['new_password'];
                $passObj = new DefaultPasswordHasher;
                $userUpdatedArray = $this->Users->saveUserPassword($email, $passObj->hash($newPassword));

                if ($userUpdatedArray) {
                    $session = $this->request->getSession();
                    $session->write('User', $userUpdatedArray);

                    $this->Users->resetRemoveToken($email); //prevent phishing / replay attack

                    $this->Flash->success('New password has been updated and you are logged in');
                    $this->redirect('/');
                } else {
                    $this->Flash->error('Password could NOT be updated');
                }
            } else {
                $this->Flash->error('Email and/or token is not correct - could NOT reset the password');
            }
        } elseif (!$email || !$resetToken) {
            $this->writeToLog('debug', 'Email and/or token are missing', true);
            $this->Flash->error('Email and/or token are missing');
            $this->redirect('/');
        } else {
            //show a form so they can manually reset the password
            $user = $this->Users->getUserByEmailAndResetToken($email, $resetToken);
            if (!empty($user)) {
                //correct token
                $this->writeToLog('debug', 'Correct token, showing form');
                $this->set('email', $email);
            } else {
                //token is not correct
                $this->writeToLog('debug', 'Email and/or token is NOT correct');

                $this->Flash->error('Email and/or token is not correct');
                $this->redirect('/');
            }
        }
    }
}
