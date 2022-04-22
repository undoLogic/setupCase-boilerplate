<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\View\Helper;

use Cake\Core\App;
use Cake\Core\Exception\CakeException;
use Cake\Routing\Asset;
use Cake\Routing\Router;
use Cake\View\Helper;

/**
 * UrlHelper class for generating URLs.
 */
class AppHelper extends Helper
{
    //started the language stuff

    function url($url = null, $full = false) {

        if(!isset($url['language']) && isset($this->params['language'])) {

            if (is_array($url)) {
                $url['language'] = $this->params['language'];
            }

        }

        return parent::url($url, $full);

    }

}
