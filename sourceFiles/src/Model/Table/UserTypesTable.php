<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class UserTypesTable extends Table
{
    public function initialize(array $config):void
    {
        //$this->addBehavior('Timestamp');
        parent::initialize($config);
        $this->setTable('user_types');
        // associations
        $this->hasMany('Users', [
            'foreignKey' => 'user_type_id'
        ]);
    }

}// end
