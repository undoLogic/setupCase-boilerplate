<?php

namespace App\Util;
use Cake\ORM\Table;
use Cake\Datasource\FactoryLocator;
use Cake\Utility\Security;

class Assets {



    static function encryptUrl($id) {
        $cipher = self::encrypt($id);
        return strtr(base64_encode($cipher), '+/', '-_');
    }
    static function encrypt($id) {

        return Security::encrypt($id, self::encryptionKey());
    }


    static function encryptionKey() {
        return 'RP6GRt9bQPVRZsKNYofTcLFRyKRVgBws';
    }


    static function decrypt($encrypted_id) {
        return Security::decrypt($encrypted_id, self::encryptionKey());
    }
    static function doesEncryptionMatch($id, $encrypted_order_id) {
        $decrypted_id = self::decrypt($encrypted_order_id);
        if ($id == $decrypted_id) {
            return true;
        } else {
            return false;
        }
    }





    static function decryptUrl($encryptedUrl) {
        $encrypted = strtr($encryptedUrl, '-_', '+/');
        return self::decrypt(
            base64_decode($encrypted)
        );
    }
    static function doesEncryptionUrlMatch($id, $encrypted_order_id_url) {
        $decrypted_id = self::decryptUrl($encrypted_order_id_url);
        if ($id == $decrypted_id) {
            return true;
        } else {
            return false;
        }
    }


    static function getImage($webroot, $prefix, $code_id) {

        $str = '<img src="';
        $str .= $webroot;
        $str .= $prefix.'/Products/imageDisplay/image_';
        $str .= $code_id;
        $str .= '_A" style="height: 100px;"';
        $str .= '/>';

        return $str;
    }

    static function getImageLazy($webroot, $prefix, $code_id) {

        $str = '<img alt="Image '.$code_id.'" data-src="';
        $str .= $webroot;
        $str .= $prefix.'/Products/imageDisplay/image_';
        $str .= $code_id;
        $str .= '_A" style="height: 100px;"';
        $str .= '/>';

        return $str;
    }
}
