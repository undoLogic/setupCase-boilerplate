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

use App\Util\SetupCase;
use Cake\Controller\Controller;
//use Cake\Error\Debugger;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\Routing\Router;
use Cake\Http\Session\DatabaseSession;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event); // TODO: Change the autogenerated stub

        $this->setupCase();

        //LANG: Add to <html tag = <html lang="<?= $this->Lang->get(); .....

        //When added layouts in the future add a variable eg <img src="assets.... changes to <img src="<?= $baseLayout; ?\>assets....
        //$this->set('baseLayout', Router::url('/').'modules'.DS.'layout'.DS);

        Log::debug('appcontroller');

    }// end of beforeFilter

    function setupCase() {

        //RBAC/Access middleware decides if they are allowed in - here we redirect if needed
        $access_granted = $this->request->getAttribute('access_granted');
        if (!$access_granted) {
            $this->Flash->error($this->request->getAttribute('access_msg'));
            $this->redirect($this->referer());
        }

        //only force these sites to be ssl
//        $sslSites = [
//            'www.livesite.com',
//        ];
//        $setupCase = new SetupCase();
//        if ($setupCase->isLIVE($_SERVER['HTTP_HOST'], $sslSites)) {
//            $setupCase->forceSSL($this);
//        }

        //We handle all RBAC from our RBAC middleware - disable the CakePHP authentication for all pages
        $this->Authentication->addUnauthenticatedActions([ $this->request->getAttribute('params')['action'] ]);

        $this->set('webroot', Router::url('/'));
    }

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
    }

    private function session()
    {
        $session = $this->getRequest()->getSession();
        return $session;
    }

    public function writeToLog($filename, $message, $newLine = false)
    {
        if ($newLine) {
            $message = "\n" .date('Ymd-His') . '-'.microtime(true) . ' > ' . $message;
        } else {
            $message = ' > ' . $message;
        }
        if ($filename == 'debug') {
            Log::debug($message);
        } else if ($filename == 'error') {
            Log::error($message);
        } else {
            die($filename.' is not setup yet');
        }

        //old method allowing to have same line logs
        //file_put_contents(LOGS.DS.$filename.'.log', $message, FILE_APPEND);
    }

    function jsonHeaders($data){
        header('Content-Type: application/json');
        echo $data;
        exit;
    }

}
