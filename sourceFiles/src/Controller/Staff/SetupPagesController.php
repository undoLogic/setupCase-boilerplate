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

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
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


    function home() {

    }
    function dashboard(){

        $this->writeToLog('debug' ,'Admin: dashboard', true);

        // pr('in admin pages dashboard');

       // pr ( $this->getLoggedInUser() );

        //pr ( $this->request->getAttributes());
    }

    function ajaxDragDropUploader() {

        $res = array();

        $this->writeToLog('debug', 'Ajax Images');
        $this->writeToLog('debug', json_encode($_FILES), true);
        $arr_file_types = ['image/png', 'image/gif', 'image/jpg', 'image/jpeg'];

        $filename = $_FILES['file']['name'];
        $file = $_FILES['file']['tmp_name'];

        if (isset($_FILES['file'])) {

            $fileType = $_FILES['file']['type'];
            if (!(in_array($fileType, $arr_file_types))) {
                $res = array('STATUS' => 400, 'MSG' => 'ERROR: "'.$fileType.'" is not allowed (only images allowed) for file '.$filename);
            } else {

                $tmp = explode('_', $filename);

                if (isset($tmp[1])) {
                    //we have 2 parts good

                    //let's strip off the filetype
                    $tmpp = explode('.', $tmp[1]);
                    $imageVersion = $tmpp[0];

                    if (in_array($imageVersion, array('A','B','C','D'))) {
                        //good

                        $codeExists = $this->Product->doesCodeExist($tmp[0]);
                        if ($codeExists) {
                            $code = $tmp[0];

                            $storage = ClassRegistry::init('Storage', 'Model');

                            $key_name = 'image_'.$code.'_'.$imageVersion;

                            $didSave = $storage->put($key_name,
                                file_get_contents($file),
                                mime_content_type($file),
                                $filename
                            );

                            if ($didSave) {
                                //good we can save
                                $res = array('STATUS' => 200, 'MSG' => 'Success: '.$filename.' added to product '.$codeExists);
                            } else {
                                //good we can save
                                $res = array('STATUS' => 400, 'MSG' => 'ERROR saving - image is named correctly and product code exists');
                            }

                        } else {
                            //bad code does NOT exist
                            $res = array('STATUS' => 400, 'MSG' => 'ERROR: that CODE does not exist. Ensure the filename is CODE_A.jpg - '.$filename);
                        }
                    } else {
                        //bad filename not setup correctly
                        $res = array('STATUS' => 400, 'MSG' => 'ERROR: missing the image version - '.$imageVersion.' - Eg CODE_A.jpg - '.$filename);
                    }
                } else {
                    //bad filename not setup correctly
                    $res = array('STATUS' => 400, 'MSG' => 'ERROR: the filename "'.$filename.'" is not setup correctly Eg CODE_A.jpg');
                }

                //$this->writeToLog('debug','Uploading: '.$filename, true);
                //$this->writeToLog('debug','file: '.$_FILES['file']['tmp_name'], true);

            }
        } else {
            $res = array('STATUS' => 400, 'MSG' => 'Nothing to upload');
        }

        echo json_encode($res);

        die;
    }


}
