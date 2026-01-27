<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Utility\Text;
//use Cake\Validation\Validator;

class LocationsTable extends Table
{
    public function initialize(array $config):void
    {
        parent::initialize($config); // REQUIRED

        $this->setTable('locations');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog');

       // belongsToMany
        $this->belongsToMany('Users', [
            'joinTable' => 'locations_users',
            'foreignKey' => 'location_id',
            'targetForeignKey' => 'user_id', //join table column - product_id
        ]);
    }



}// end
