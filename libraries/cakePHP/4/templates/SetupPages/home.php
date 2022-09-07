<?php if (isset($isLoggedIn)): ?>
    LOGGED IN (<?php echo $this->Html->link('Logout', '/logout'); ?>)
<?php else: ?>
    NOT logged in (<?php echo $this->Html->link('Login', '/login'); ?>)
<?php endif; ?>

- <?php echo $this->Html->link('Reset', array('prefix' => false, 'controller' => 'Users', 'action' => 'beginReset')); ?>

- <?php echo $this->Html->link('AddUser', array('prefix' => false, 'controller' => 'Users', 'action' => 'add')); ?>

<hr/>



<h2>
    current lang: <?php echo $lang; ?>
</h2>

<br/>

<?php echo $this->Html->link('Home page EN', array(
    'language' => 'en'
)); ?>

<br/>

<?php echo $this->Html->link('Home page FR', array(
    'language' => 'fr'
)); ?>

<br/>

<?php echo $this->Html->link('Home page NOT SET', array()); ?>

<hr/>


<h2>
    Prefix
</h2>

<?php echo $this->Html->link('Staff page', array(
    'prefix' => 'Staff',
)); ?>

<br/>

<?php echo $this->Html->link('Admin page', array(
    'prefix' => 'Admin',
)); ?>

<hr/>

<h2>
    Object Storage
</h2>

<div class="row">
    <div class="col-4">
        <?php echo $this->Form->create(null, ['type' => 'file', 'url' => ['controller' => 'SetupPages', 'action' => 'objAdd']]); ?>

        <?php echo $this->Form->file('fileToUpload', ['type' => 'button']); ?>

        <?= $this->Form->button('Upload'); ?>

        <?php echo $this->Form->end(); ?>
    </div>
</div>

<?php foreach ($objects as $object) : ?>
    <div class="row">
        <div class="col-lg-3">Filename: <?= $object['filename']; ?> (key_name: <?= $object['key_name']; ?>)</div>
        <div class="col-lg-3" style="margin-left: 5px;">

            <?php if ($object['current']): ?>
                CURRENT
            <?php else: ?>
                ARCHIVED
            <?php endif; ?>

            <?= $this->Html->link('Download', ['action' => 'objDownload', $object['key_name']]); ?>
            <a style="color: #000000; font-weight: bold;" href="<?= $webroot;?>SetupPages/objRemoveCache/<?= $object['key_name']; ?>">Remove-Cache</a>
            <a style="color: red; font-weight: bold;" href="<?= $webroot;?>SetupPages/objDelete/<?= $object['key_name']; ?>">X</a>
        </div>
    </div>
<?php endforeach; ?>

<h2>CSS</h2>
<div>
    <?php echo $this->Html->link('Responsive Table', ['controller' => 'SetupPages', 'action' => 'responsiveTable']); ?>
    <br/>
    <?php echo $this->Html->link('Sticky Content', ['controller' => 'SetupPages', 'action' => 'sticky']); ?>
</div>



<h2>Javascript</h2>

<div>
    <?php echo $this->Html->link('VUE validation', ['language' => 'en', 'controller' => 'SetupPages', 'action' => 'formValidation']); ?>
</div>


<div>
    <?php echo $this->Html->link('VUE Set Timer', ['language' => 'en', 'controller' => 'SetupPages', 'action' => 'setTimer']); ?>
</div>


<div>
    <?php echo $this->Html->link('IncreaseLimit', ['controller' => 'SetupPages', 'action' => 'increaseLimit']); ?>
</div>






<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
