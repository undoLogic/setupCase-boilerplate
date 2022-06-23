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
    function beforeFilter(EventInterface $setupPages)
    {
        parent::beforeFilter($setupPages);
        $this->objectStorages = TableRegistry::getTableLocator()->get('ObjectStorages');
    }

    var $objectStorages;

    function dashboard()
    {
        //let's redirect to the prefix admin (I was not able to do this in the prefix not sure why)
        $this->redirect(array(
            'prefix' => 'Admin',
            'controller' => 'SetupPages',
            'action' => 'dashboard'
        ));
    }

    function index()
    {
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

    function home()
    {
        $this->set('objects', $this->objectStorages->getObjects());
    }

    function sticky() {

    }

    function objAdd()
    {
        if ($this->request->is('post')) {
            $attachment = $this->request->getData('fileToUpload');
            $filename = $attachment->getClientFilename();
            $typeOfUpload = $attachment->getClientMediaType();
            $size = $attachment->getSize();
            $uploadedFile = $attachment->getStream()->getMetadata('uri');
            $error = $attachment->getError();

            $mime = mime_content_type($uploadedFile);

            $key_name = 'key_name_' .$filename;
            $res = $this->objectStorages->putObject($key_name, file_get_contents($uploadedFile), $mime, $filename);
            if ($res['status'] == 200) {
                $this->Flash->success('File added to object storage');
            } else {
                $this->Flash->error('Problem adding to object storage');
            }
        }
        $this->redirect($this->referer());
    }

    function objDownload($keyName)
    {
        $res = $this->objectStorages->getFileFromCache($keyName);
        $downloadName = 'downloadname.' . $res['extension'];
        if ($res['STATUS'] == 200) {
            header('Content-Type: ' . $res['mime'] . '; charset=utf-8');
            header('Content-Disposition: attachment; filename=' . $downloadName);
            echo file_get_contents($res['path']);
            exit;
        } else {
            die('found found');
        }
    }

    function objRemoveCache($keyName)
    {
        if ($this->objectStorages->removeCache($keyName)) {
            $this->Flash->success('Deleted');
        }
        $this->redirect($this->referer());
    }

    function objDelete($keyName)
    {
        if ($this->objectStorages->deleteObject($keyName)) {
            $this->Flash->success('Deleted Object');
        }
        $this->redirect($this->referer());
    }
}
