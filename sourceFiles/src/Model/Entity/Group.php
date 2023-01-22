<?php

namespace App\Model\Entity;

use Cake\Core\Configure;
use Cake\ORM\Entity;

class Group extends Entity
{
    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];

    //entity accosor


}// end
