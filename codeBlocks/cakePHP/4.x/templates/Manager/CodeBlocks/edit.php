<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CodeBlock $entity
 */
?>

<h1>Edit Code Block</h1>

<?= $this->Form->create($entity) ?>
<?= $this->Form->control('name') ?>
<?= $this->Form->control('description', ['type' => 'textarea']) ?>

<?= $this->Form->button(__('Save Changes')) ?>
<?= $this->Form->end() ?>
