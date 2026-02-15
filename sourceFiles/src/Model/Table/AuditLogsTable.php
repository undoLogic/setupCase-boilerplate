<?php
// src/Model/Table/AuditLogsTable.php

namespace App\Model\Table;

use Cake\ORM\Table;

class AuditLogsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('audit_logs');
        $this->setPrimaryKey('id');

        // Optional but recommended
        $this->addBehavior('Timestamp', [
            'created' => 'created',
            'modified' => false,
        ]);
    }
}

