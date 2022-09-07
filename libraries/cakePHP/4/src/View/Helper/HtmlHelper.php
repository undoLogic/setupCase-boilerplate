<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Html helper
 */
class HtmlHelper extends Helper\HtmlHelper
{

    public function link($title, $url = null, array $options = []): string
    {
        if (is_array($url)) {
            //@todo get language from the request
            if (!isset($url['language'])) {
                $url['language'] = Configure::read('lang');
            }
        }
        return parent::link($title, $url, $options);
    }

}
