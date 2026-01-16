<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\ResultSetInterface $records
 */
?>

<h1>Code Blocks</h1>

<p>
    <?= $this->Html->link(
        'Create New Code Block',
        ['action' => 'create'],
        ['class' => 'button']
    ) ?>
</p>

<?php if (!$rows->count()): ?>
    <p>No records found.</p>
<?php else: ?>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Created</th>
            <th class="actions">Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $record): ?>
            <tr>
                <td><?= h($record->id) ?></td>
                <td><?= h($record->name) ?></td>
                <td><?= $record->created?->format('Y-m-d') ?></td>
                <td class="actions">
                    <?= $this->Html->link('View', ['action' => 'view', $record->id]) ?>
                    <?= $this->Html->link('Edit', ['prefix' => 'Manager', 'action' => 'edit', $record->id]) ?>
                    <?= $this->Form->postLink(
                        'Delete',
                        [
                            'prefix' => 'Manager', 'action' => 'delete', $record->id],
                        ['confirm' => 'Are you sure?']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php endif; ?>
