<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

class GroupsTable extends Table
{
    public function initialize(array $config):void
    {
        //$this->addBehavior('Timestamp');
        parent::initialize($config);
        $this->setTable('groups');

        // associations
        $this->hasMany('Users', [
            'foreignKey' => 'group_id'
        ]);
    }

}// end
