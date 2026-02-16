<?php
namespace App\View\Helper;

use Cake\View\Helper;

class MenuStateHelper extends Helper
{
    public function isActive(string $key, string $current): string
    {
        return $key === $current ? 'active' : '';
    }

    public function isOpen(string $key, string $current): string
    {
        return $key === $current ? 'pcoded-trigger' : '';
    }
}
