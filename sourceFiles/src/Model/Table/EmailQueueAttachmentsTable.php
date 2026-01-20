<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Utility\Text;
//use Cake\Validation\Validator;

class EmailQueueAttachmentsTable extends Table
{
    public function initialize(array $config):void
    {
        parent::initialize($config); // REQUIRED

        $this->setTable('email_queue_attachments');

        $this->addBehavior('Timestamp');
        $this->addBehavior('AuditLog');

        //belongsTo
        $this->belongsTo('EmailQueues', [
            'foreignKey' => 'email_queue_id'
        ]);
    }

}// end
