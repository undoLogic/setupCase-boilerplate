<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CodeBlock $entity
 */
?>

<h1>Code Block Details</h1>

<table class="vertical-table">
    <tr>
        <th>ID</th>
        <td><?= h($entity->id) ?></td>
    </tr>
    <tr>
        <th>Name</th>
        <td><?= h($entity->name) ?></td>
    </tr>
    <tr>
        <th>Description</th>
        <td><?= nl2br(h($entity->description)) ?></td>
    </tr>
    <tr>
        <th>Created</th>
        <td><?= $entity->created?->format('Y-m-d H:i') ?></td>
    </tr>
    <tr>
        <th>Modified</th>
        <td><?= $entity->modified?->format('Y-m-d H:i') ?></td>
    </tr>
</table>

<p class="actions">
    <?= $this->Html->link('Edit', ['action' => 'edit', $entity->id]) ?>
    <?= $this->Form->postLink(
        'Delete',
        ['action' => 'delete', $entity->id],
        ['confirm' => 'Are you sure you want to delete this record?']
    ) ?>
    <?= $this->Html->link('Back to list', ['action' => 'index']) ?>
</p>
