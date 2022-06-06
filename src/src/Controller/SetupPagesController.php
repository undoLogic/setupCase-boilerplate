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
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Http\Session;
use Cake\View\Exception\MissingTemplateException;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class SetupPagesController extends AppController
{
    function dashboard(){
        //let's redirect to the prefix admin (I was not able to do this in the prefix not sure why)

        $this->redirect(array(
            'prefix' => 'Admin',
            'controller' => 'SetupPages',
            'action' => 'dashboard'
        ));

        //pr('in NOT admin pages dashboard'); exit;
    }

    function index() {
        //get the current lange
        $current_language = $this->setupLanguage();

        $this->redirect(
            array(
                'language' => $current_language,
                'controller' => 'SetupPages',
                'action' => 'home'
            )
        );
    }
    function home() {
        //pr ($name);
        //exit;
    }

    function login() {
        //if not empty post
            //verify that the password and email match the database ($this->User->verifyPassword($email, $password);
                //if success
                    //store the whole user object including the relations. there are many times that it will help that we can have that data within the session to verify against
                    //only use the session build into cakePHP
                    $session = $this->request->getSession();
                    $session->write('User.name', 'Ralph 88888');
                    $name = $session->read('User.name');
                    $user = $this->User->find('first');
                    $session->write('User', $user);


        //else
            //show error with the new session set flash module for cakephp 4 that there was an error logging in
    }

    function logout() {
        //remove the session which was holding the user object
        //show a message they were logged out
        //redirect to the home page
    }

    function startReset() {
        //accept an email from a post form
            //if the email exists -> there should be a new column in the users table 'reset_token' get a random text string 8 alpha characters and add that into the users database
                //email that token to the users email on file
    }
    function reset($email, $token) {
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
