current lang: <?php echo $baseLang; ?>

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
