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
use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{
    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.

     */



    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue

    }
    // login
    public function login()
    {
  //echo (new DefaultPasswordHasher())->hash('test123'); exit;
        //pr($this->Authentication->getResult()); exit;
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result->isValid()) {
            // redirect to /articles after login success
            $redirect = $this->request->getQuery('redirect', [
                'controller' => 'Articles',
                'action' => 'index',
            ]);

            return $this->redirect($redirect);
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    // index
    public function index(){

        $users = $this->Users->find('all');
        $users = $users->toArray();

        $this->set(compact('users'));
    }
    // view
    public function view($id = null){
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
    }
    public function edit(){

    }
    public function jsonAddUser(){
        $objData=file_get_contents('php://input');
        if(empty($objData)){
            $objData = '{"name":"Ron Doe","email":"ron@gmail.copm","telephone":"514-1123-4567"}';
        }
        if($this->Users->jsonAddUser($objData)){
            echo true;
        }else{
            echo false;
        }
        exit;
    }
//    public function add(){
//        if(!empty($this->request->getData())){
//            $user = $this->request->getData();
//            pr($this->request->getData()); //exit;
//            pr(new DefaultPasswordHasher())->hash($user['password']); exit;
//        }
       //pr('here');
//        $users = $this->Users->newEmptyEntity();
//
//            if ($this->request->is('post')) {
//                $users = $this->Users->patchEntity($users, $this->request->getData());
//                pr($users); exit;}

  //  }

    public function add(){

            //$users = $this->Users->newEmptyEntity();

            if ($this->request->is('post')) {
                //$users = $this->Users->patchEntity($users, $this->request->getData());
                //pr($users); exit;
                if ($this->Users->save($this->request->getData())) {
                    $this->Flash->success(__('The User has been saved.'));

                    return $this->redirect(['action' => 'index']);
                }
                $this->Flash->error(__('The User could not be saved. Please, try again.'));
            }




    }// end of add


}// end
