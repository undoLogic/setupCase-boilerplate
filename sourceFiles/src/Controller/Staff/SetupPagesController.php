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

namespace App\Controller\Staff;

//share the appcontroller between all the views
use App\Controller\AppController;

use App\Util\SetupFiles;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\Log\Log;
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


    function home()
    {

    }

    function dashboard()
    {

        $this->writeToLog('debug', 'Admin: dashboard', true);

        // pr('in admin pages dashboard');

        // pr ( $this->getLoggedInUser() );

        //pr ( $this->request->getAttributes());
    }

    function dragDrop()
    {

        Log::debug('testing');

        $this->set('allowedFileTypes', $this->allowedFileTypes);

        $token = $this->request->getAttribute('csrfToken');
        $this->set('csrf', $token);

    }

    var $allowedFileTypes = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

    function ajaxDragDrop()
    {
        $res = array();

        Log::debug(json_encode($_FILES));

        if (!isset($_FILES['file'])) {
            $res = array('STATUS' => 400, 'MSG' => 'Nothing to upload');
        } else {
            $upload = $_FILES['file'];
            if (!(in_array($upload['type'], $this->allowedFileTypes))) {
                $res = array('STATUS' => 400, 'MSG' => 'ERROR: "' . $upload['type'] . '" is not allowed for ' . $upload['name']);
            } else {
                $setupFiles = new SetupFiles();
                $fileRes = $setupFiles->put($upload['name'], file_get_contents($upload['tmp_name']), $upload['name']);
                if ($fileRes['STATUS'] == 200) {
                    $res = array('STATUS' => 200, 'MSG' => 'File '.$upload['name'].' saved');
                } else {
                    $res = array('STATUS' => 500, 'MSG' => 'ERROR file '.$upload['name'].' could not be saved');
                }
            }
        }
        echo json_encode($res);
        die;
    }


}
