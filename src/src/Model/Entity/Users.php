<?php
// src/Model/Entity/Article.php
namespaceApp\Model\Entity;

useCake\ORM\Entity;

class Users extends Entity
{
    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];
}
