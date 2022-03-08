<?= $this->Form->create(); ?>
<label>Name</label>
<?= $this->Form->input('name',[
    'type' => 'text'
]);
?>

<label>Email</label>
<?= $this->Form->input('email',[
    'type' => 'text'
]);
?>


<?= $this->Form->submit('Add',[]); ?>
<?= $this->Form->end(); ?>
