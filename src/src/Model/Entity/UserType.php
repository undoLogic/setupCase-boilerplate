<?php



namespace App\Model\Entity;
use Cake\ORM\Entity;

class UserType extends Entity
{
    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];
}
