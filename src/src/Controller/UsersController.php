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

    function testing()
    {

        $email = 'sachalewis@undologic.com';
        $pass = '1234';

        $passObj = new DefaultPasswordHasher;

        $hash = ($passObj)->hash($pass);

        $this->writeToLog('debug', 'pass is: ' . $pass, true);
        $this->writeToLog('debug', 'hash is: ' . $hash, true);
        $isCorrect = $passObj->check($pass, $hash);
        $this->writeToLog('debug', 'isCorrect: ' . $isCorrect, true);


        $didSave = $this->Users->saveUserPassword($email, $hash);
        $this->writeToLog('debug', 'didSave: '.$didSave, true);


        $userArray = $this->Users->getUserByEmail($email);
        pr ($userArray);


        $session = $this->request->getSession();
        $session->write('User', $userArray);

        $sessionUser = $session->read('User');

        pr ($sessionUser);


        exit;

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
                    return $this->redirect('/dashboard');

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

    function startReset()
    {
        //accept an email from a post form
        //if the email exists -> there should be a new column in the users table 'reset_token' get a random text string 8 alpha characters and add that into the users database
        //create the token with Text::uuid()
        //https://book.cakephp.org/4/en/core-libraries/text.html
        //email that token to the users email on file
        $this->send('email@email.com', 'Reset Password');
    }

    function reset($email, $token)
    {
        //this will be clicked from a link in a email
        //check that the email and token do match
        //if they do show a screen to enter a NEW password (with a verify password)

        //if not empty this->request->data
        //they are entering a new password
        //once again verify the email and token do exist
        //if they do exist using the cakePHP create hash get a new password hash and update the database password
        //if the password was successfully changed REMOVE the token in the users table so they cannot use it again as a 'replay attack'
        //get the user Object and auto log them in and redirect to the /dashboard page (which will require a login prefix)

    }
}
