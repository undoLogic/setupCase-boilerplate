<?php
// src/Model/Behavior/AuditLogBehavior.php

namespace App\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\Event\EventInterface;
use Cake\Datasource\EntityInterface;
use Cake\I18n\FrozenTime;
use Cake\Datasource\FactoryLocator;
use App\Util\AuditContext;

class AuditLogBehavior extends Behavior
{
    protected $_defaultConfig = [
        'actions' => ['insert', 'update', 'delete'],
    ];

    public function afterSave(
        EventInterface $event,
        EntityInterface $entity,
        $options
    ): void {
        // DEBUG CONFIRMATION
        // dd('afterSave fired');

        $action = $entity->isNew() ? 'insert' : 'update';

        if (!in_array($action, $this->getConfig('actions'), true)) {
            return;
        }

        $this->logChange($entity, $action);
    }

    public function beforeDelete(
        EventInterface $event,
        EntityInterface $entity,
        $options
    ): void {
        if (!in_array('delete', $this->getConfig('actions'), true)) {
            return;
        }

        $this->logChange($entity, 'delete');
    }

    protected function logChange(EntityInterface $entity, string $action): void
    {
        $table = $this->table();

        // Prevent recursion
        if ($table->getAlias() === 'AuditLogs') {
            return;
        }

        //$auditLogs = $table->getTableLocator()->get('AuditLogs');

        $auditLogs = FactoryLocator::get('Table')->get('AuditLogs');



        $userId = AuditContext::userId();
        $ip     = AuditContext::ip();

        $auditLogs->saveOrFail(
            $auditLogs->newEntity([
                'table_name'      => $table->getTable(),
                'entity_id'       => $entity->id ?? null,
                'action'          => $action,
                'changed_fields'  => $entity->getDirty()
                    ? json_encode($entity->extract($entity->getDirty()))
                    : null,
                'original_fields' => json_encode($entity->getOriginalValues()),
                'user_id'         => $userId,
                'ip_address'      => $ip,
                'created'         => FrozenTime::now(),
            ])
        );
    }
}
