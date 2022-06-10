<?php if (isset($isLoggedIn)): ?>
    LOGGED IN (<?php echo $this->Html->link('Logout', '/logout'); ?>)
<?php else: ?>
    NOT logged in (<?php echo $this->Html->link('Login', '/login'); ?>)
<?php endif; ?>

- <?php echo $this->Html->link('Reset', array('prefix' => false, 'controller' => 'Users', 'action' => 'beginReset')); ?>

- <?php echo $this->Html->link('Signup', array('prefix' => false, 'controller' => 'Users', 'action' => 'signup')); ?>

<hr/>

<h2>
    current lang: <?php echo $baseLang; ?>
</h2>

<br/>

<?php echo $this->Html->link('Home page EN', array(
    'language' => 'en_US'
)); ?>

<br/>

<?php echo $this->Html->link('Home page FR', array(
    'language' => 'fr_CA'
)); ?>

<br/>

<?php echo $this->Html->link('Home page NOT SET', array()); ?>

<hr/>

<h2>
    Prefix
</h2>

<?php echo $this->Html->link('Admin page', array(
    'prefix' => 'Admin',
)); ?>




<hr/>

<h2>
    Object Storage
</h2>

<div class="row">
    <div class="col-4">
        test
    </div>
    <div class="col-4">
        <?php echo $this->Form->create(null, ['type' => 'file']); ?>

        <?php echo $this->Form->file('test', ['type' => 'button']); ?>

        <?php echo $this->Form->end(); ?>
    </div>
    <div class="col-4">
        test
    </div>
</div>



