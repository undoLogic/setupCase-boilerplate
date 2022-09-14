<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\TableRegistry;

use Cake\ORM\Locator\LocatorAwareTrait;

class ObjectStoragesTable extends Table
{
    public function initialize(array $config):void
    {
        $dsn = 'mysql://root:undologic@db/object_storage';
        ConnectionManager::setConfig('object_storage', ['url' => $dsn]);
        $connection = ConnectionManager::get('object_storage');
        $this->setConnection($connection);
        $this->setTable('files');
    }

    function getObjects() {
        return $this->find('all')->toArray();

    }

    var $cacheLocation = '';

    function setupPaths()
    {
        $this->cacheLocation_data = APP . 'Files/cache/data/';
    }

    var $conversions = array(
        'octet-stream' => 'zip',
        'zip' => 'zip',
        'pdf' => 'pdf',
        'vnd.openxmlformats-officedocument.spre' => 'xlsx',
        'postscript' => 'pdf'
    );
//
    var $images = array(
        'jpeg',
        'png',
        'gif',
        'jpg'
    );
//
    function removeCache($key_name)
    {
        $this->setupPaths();

        $cmd = 'rm ' . $this->cacheLocation_data . $key_name . '*';
        // pr ($cmd);
        exec($cmd, $out);

        return true; //@todo add a check later
    }

    function getFileFromCache($key_name)
    {

        $this->setupPaths();

        $res = array();

        $files = glob($this->cacheLocation_data . $key_name . ".*");

        if (!empty($files)) {

            //$this->writeToLog('debug', 'CACHE: have a cache', true);
            $path_parts = pathinfo($files[0]);
            //pr ($path_parts);exit;
            if ($path_parts['extension'] == 'empty') {
                //no image set the placeholder
                $res['STATUS'] = 400;
                $res['MSG'] = 'bad extension';
            } else {
                $res['STATUS'] = 200;
                $res['MSG'] = 'Found image';
                //pr ($this->images);
                if (in_array($path_parts['extension'], $this->images)) {
                    $res['mime'] = 'image/' . $path_parts['extension'];
                } else {
                    $res['mime'] = 'application/' . $path_parts['extension'];
                }
                $res['extension'] = $path_parts['extension'];
                $res['path'] = $files[0];
            }

            //pr ($res);exit;
        } else {

            //$this->writeToLog('debug', 'CACHE: Creating a data cache', true);

            $file = $this->getObject($key_name);

            $mimeParts = explode('/', $file['mime']);

            //pr ($mimeParts);exit;
            if ($mimeParts[0] == 'image') {
                $extension = str_replace("image/", '', $file['mime']);
            } elseif ($mimeParts[0] == 'application') {
                $tempExt = str_replace("application/", '', $file['mime']);
                if (isset($this->conversions[$tempExt])) {
                    $extension = $this->conversions[$tempExt];
                } else {
                    $extension = 'unknown';
                }
            } elseif ($mimeParts[0] == 'video') {
                $extension = str_replace("video/", '', $file['mime']);
            } elseif ($mimeParts[0] == 'text') {
                $extension = '.txt';
            }

            $newImage = $this->cacheLocation_data . $key_name . '.' . $extension;

            //pr ($newImage);exit;
            //pr ($file);exit;
            file_put_contents(
                $newImage,
                base64_decode($file['data'])
            );

            $res['STATUS'] = 200;
            $res['MSG'] = 'Created cache and returned image';
            $res['mime'] = $file['mime'];
            $res['extension'] = $extension;
            $res['path'] = $newImage;

        }
        return $res;
    }

    private function doesKeyNameExist($key_name)
    {
        $this->setDataSource('storage');

        $conditions = array(
            'AND' => array(
                array('Storage.current' => true),
                array('Storage.key_name' => $key_name),
            )
        );

        $found = $this->find('first', array(
            'conditions' => $conditions,
            //'order' => 'Storage.id ASC'
        ));
        if (!empty($found)) {
            return $key_name;
        } else {
            return false;
        }
    }

    var $mimesToProcess = array(
        'image/gif',
        'image/jpeg',
        'application/pdf',
        'image/png',
        'image/tiff',
        'image/x-eps',
        'image/webp'
    );

    function getObject($key_name)
    {
        $return = [];

        $conditions = [
            'AND' => [
                ['ObjectStorages.current' => true],
                ['ObjectStorages.key_name' => $key_name],
            ]
        ];

        $found = $this->find('all', [
            'conditions' => $conditions
                ])->first();

        $binaryData = stream_get_contents($found->data);
        $base64Data = base64_encode($binaryData);

        $array = $found->toArray();

       // pr ($base64Data);
       // pr ($found);exit;
        if (!empty($found)) {
            $return['status'] = 200;
            $return['status_msg'] = "Found #" . $array['key_name'];
            $return['data'] = $base64Data;
            $return['mime'] = $array['mime'];
            $return['filename'] = $array['filename'];

        } else {
            $return['status'] = 404;
            $return['status_msg'] = "Nothing found in the database for the " . $key_name;
        }

        return $return;

    }

    function markOld($key_name)
    {
        $this->updateAll(array(
            'current' => 0
        ),
            array(
                'key_name' => $key_name
            )
        );

    }

    function putObject($key_name, $data, $mime, $filename)
    {

        $this->removeCache($key_name);

//        pr ($key_name);
//        pr ($data);
//        pr ($mime);
//        pr ($filename);
//        exit;

        $this->markOld($key_name);


        $domain = $_SERVER['HTTP_HOST'];
        $data_md5 = md5($data);

        $object = $this->newEmptyEntity();

        //write to the db
        $object->current = true;
        $object->domain = $domain;
        $object->key_name = $key_name;
        $object->mime = $mime;
        $object->data = $data;
        $object->verify = $data_md5;
        $object->filename = $filename;

        $return = array();
        $insertJson = "md5: " . $data_md5 . " calculated here:" . md5($data);
        $return['insert_msg'] = $insertJson;

        if ($this->save($object)) {
            $return['id'] = $object->id;
            $return['status'] = 200;
            $return['status_msg'] = 'Saved';
        } else {
            $return['status'] = 500;
            $return['status_msg'] = 'ERROR';
        }

        return $return;

    }

    function deleteObject($key_name)
    {
        $this->removeCache($key_name);

        return $this->deleteAll(
            array('Storage.key_name' => $key_name), false
        );
    }
//
//}


}// end
