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

use Cake\Datasource\ConnectionManager;

use Cake\ORM\TableRegistry;



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

    function objAdd() {

    }

    function objView() {

        $objectStorage = TableRegistry::getTableLocator()->get('ObjectStorages');

        pr ($objectStorage->getObjects());

        //pr ($articles);


        //$articles = $this->getTableLocator()->get('users');

// Start a new query.
       // $query = $articles->find('all');

       // pr ($query);
       // exit;



        //$connection = ConnectionManager::get('object_storage');

       // $found = $connection->find('all');

      //  pr ($found);

        die('hello');
    }

}
