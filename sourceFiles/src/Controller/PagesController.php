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

use Cake\Controller\Controller;


use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Event\EventInterface;
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
class PagesController extends AppController
{
    function beforeFilter(EventInterface $event  )
    {
        parent::beforeFilter($event);
      //  $this->objectStorages = TableRegistry::getTableLocator()->get('ObjectStorages');

    }

    function index() {

        Configure::write('DebugKit.forceEnable', true);

        $lang = $this->request->getAttribute('lang');
        $this->set('lang', $lang);
        Configure::write('lang', $lang);

        //pr ($lang);exit;
        $this->redirect([
            'language' => $lang,
            'action' => 'home'
        ]);
    }

    function signage() {
        $this->viewBuilder()->disableAutoLayout();
    }
    function home() {
       // pr($this->language()); exit;
        $this->set('home', true);
        //Configure::write("UpdateCase.slug", 'Home');

        //echo $updateCase->getContentBy('Support', 'form_title', false);

        //this will be set from app_controller
       // $webroot = Router::url('/');
        //echo  "<img src='".$webroot . $updateCase->getImage('Support', 'background', false, 'medium')."'/>";

//        $updateCase = new UpdateCase;
//        pr ($updateCase->testing());
        //exit;


    }

    function team(){
        $this->set('page_team', true);
        Configure::write("UpdateCase.slug", 'Team');

    }

    function contact(){
        $this->set('page_contact', true);
        Configure::write("UpdateCase.slug", 'Contact');
        $random_number = rand(11, 99 );
        $this->set(compact('random_number'));
        //$this->set('form_submitted', 'NOT-SUBMITTED');
    }

    function caseStudies() {
        $this->set('pageName', 'Projects');
        Configure::write("UpdateCase.slug", 'Projects');
    }
    function caseStudy($slug) {

        if (!$slug) die ('404-not found');

        $this->set('projectView', true);

        $this->set('pageName', 'Project');

        $this->set('slug', $slug);
        Configure::write("UpdateCase.slug", $slug);
    }

    function caseStudyN($slug)
    {
        //$this->viewBuilder()->disableAutoLayout() ;
        //$this->viewBuilder()->setLayout('sticky');

        if (!$slug) die ('404-not found');

        $this->set('projectView', true);

        $this->set('pageName', 'Project');

        $this->set('slug', $slug);
        Configure::write("UpdateCase.slug", $slug);
    }
    function success(){
        Configure::write("UpdateCase.slug", 'Home');
    }
    function terms(){
        Configure::write("UpdateCase.slug", 'Terms');
        $GLOBALS['UpdateCase']['slug'] = 'Terms';
    }

    function test($arg1 = false, $arg2 = false, $arg3 = false) {
        $this->viewBuilder()->disableAutoLayout() ;
    }
}
