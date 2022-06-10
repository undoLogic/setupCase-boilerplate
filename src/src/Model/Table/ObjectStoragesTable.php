<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\Datasource\ConnectionManager;
use Cake\ORM\Table;
use Cake\Utility\Text;

use Cake\ORM\TableRegistry;

use Cake\ORM\Locator\LocatorAwareTrait;

class ObjectStoragesTable extends Table
{
    public function initialize(array $config):void
    {
        $dsn = 'mysql://root:undologic@db/object_storage';
        ConnectionManager::setConfig('object_storage', ['url' => $dsn]);
        $connection = ConnectionManager::get('object_storage');
        $this->setConnection($connection);
        $this->setTable('files');
    }

    function getObjects() {
        pr ($this->find('all')->toArray());
        die('inside objects');
    }

}// end
