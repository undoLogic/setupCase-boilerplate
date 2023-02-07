<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use App\Util\SetupCase;
use Cake\ORM\Table;

class ActivityLogsTable extends Table
{
    public function initialize(array $config):void
    {
        //$this->addBehavior('Timestamp');
        parent::initialize($config);
        $this->setTable('activity_logs');

    }

    public static function defaultConnectionName(): string
    {
        return 'default';
    }

    public function addLog($user_id, $page, $notes, $addMoreTrackingitemsHere = false) {
        $row = $this->newEmptyEntity();

        $row->user_id = (int)$user_id;
        $row->page = $page;
        $row->notes = $notes;
        $row->created = date('Y-m-d H:i:s');

        if (isset($_SERVER['REMOTE_ADDR'])) {
            $row->ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $row->ip = 'N/A';
        }

        if ($this->save($row)) {
            //saved
            return $row->id;
        } else {
            SetupCase::writeToLog('info', 'cannot write to log');
        }
    }

}// end
