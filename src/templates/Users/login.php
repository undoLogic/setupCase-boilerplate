
<?= $this->Form->create(); ?>

Login

<?php echo $this->Form->input('email'); ?>
<br/>
Password <?php echo $this->Form->input('password'); ?>

<br/>

<?php echo $this->Form->button('Submit'); ?>


<?= $this->Form->end(); ?>
