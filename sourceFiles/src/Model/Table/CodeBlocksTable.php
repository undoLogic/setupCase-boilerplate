<?php
// src/Model/Table/ArticlesTable.php

namespace App\Model\Table;
use Cake\ORM\Table;
use Cake\Utility\Text;
//use Cake\Validation\Validator;

class CodeBlocksTable extends Table
{
    public function initialize(array $config):void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('code_blocks');

    }

}// end
