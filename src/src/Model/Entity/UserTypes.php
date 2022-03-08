<?php
// src/Model/Entity/Article.php
namespaceApp\Model\Entity;

useCake\ORM\Entity;

class UserTypes extends Entity
{
    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];
}
