ADMIN - current lang: <?php echo $baseLang; ?>


<?php echo $this->Html->link('Return back to NON-admin page', array(
    'prefix' => false,

)); ?>


<br/>

<?php echo $this->Html->link('Admin EN', array(
    'prefix' => 'Admin',
    'language' => 'fr_CA'

)); ?>


<br/>


<?php echo $this->Html->link('Admin FR', array(
    'prefix' => 'Admin',
    'language' => 'fr_CA'

)); ?>


<br/>


<?php echo $this->Html->link('Admin lang NOT SET', array('prefix' => 'Admin')); ?>






