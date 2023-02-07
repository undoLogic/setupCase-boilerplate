<?php

namespace App\Util;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;

class SetupFiles {

    var $fileCacheLocation = '';
    function __construct() {

        //Maybe adjust this based on your environments
        $this->fileCacheLocation = APP.'Files'.DS;
        if (empty($this->fileCacheLocation)) {
            die('missing fileCacheLocation');
        }

    }

    //File Storage
    function put($key_name, $data, $filename) {

        //save as file instead
        $info = pathinfo($filename);

        //save by our key_name, but use the extension from our original file
        $filename = $key_name.'.'.$info['extension'];

        //remove all files with the same name
        $this->removeCachedFiles($key_name);

        $saved = file_put_contents($this->fileCacheLocation.$filename, $data);

        $return = array();
        if ($saved) {
            $return['STATUS'] = 200;
            $return['MSG'] = 'Saved';
        } else {
            $return['STATUS'] = 500;
            $return['MSG'] = 'ERROR';
        }
        return $return;
    }

    function getAll() {
        $files = scandir($this->fileCacheLocation);
        $files = array_diff($files, ['.','..']);
        $list = [];
        foreach ($files as $file) {
            if ($file == 'empty') continue;
            $info = pathinfo($file);

            $info['key_name'] = $info['filename'];
            unset($info['dirname']);

            $list[ $info['filename'] ] = $info;

        }
        return $list;
    }

    function get($key_name) {

        $result = glob ($this->fileCacheLocation.$key_name.'.*');

        $res = [];

        if (isset($result[0])) {

            //we have one
            $file = $result[0];
            $info = pathinfo($file);

            $size = filesize($file);

            $res['STATUS'] = 200;
            $res['file'] = $file;
            $res['exists'] = true;
            $res['extension'] = $info['extension'];
            $res['key_name'] = $key_name;
            $res['size'] = filesize($file);

        } else {
            $res['STATUS'] = 404;
            $res['exists'] = false;
        }

        return $res;
    }

    function delete($key_name)
    {
        //maybe some checks here in case you want to protect ?
        $this->removeCachedFiles($key_name);
    }

    private function removeCachedFiles($key_name) {

        //since we don't know the extension there are always multiple files possible
        $result = glob ($this->fileCacheLocation.$key_name.'.*');
        foreach ($result as $each) {
            unlink($each);
        }
    }

}


