<?php
// src/Model/Entity/Article.php
namespaceApp\Model\Entity;

useCake\ORM\Entity;

class UserType extends Entity
{
    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];
}
