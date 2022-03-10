<!-- in /templates/Users/login.php -->
<div class="users form">
    <?= $this->Flash->render() ?>
    <h3>Signup</h3>
    <?= $this->Form->create() ?>
    <fieldset>
        <legend></legend>
        <?= $this->Form->control('name', ['required' => true]) ?>
        <?= $this->Form->control('email', ['required' => true]) ?>
        <?= $this->Form->control('password', ['required' => true]) ?>
    </fieldset>
    <?= $this->Form->submit(__('Add')); ?>
    <?= $this->Form->end() ?>


</div>
