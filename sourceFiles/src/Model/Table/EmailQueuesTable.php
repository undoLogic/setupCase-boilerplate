<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Utility\Text;
//use Cake\Validation\Validator;

class EmailQueuesTable extends Table
{
    public function initialize(array $config):void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('email_queues');

        $this->hasMany('EmailQueueAttachments', [
            'foreignKey' => 'email_queue_id'
        ]);

    }

}// end
