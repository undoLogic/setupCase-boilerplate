<?php  if($current_language === 'en'): ?>

    <?php echo $this->Html->link('fr', array(
        'language' => 'fr'
    )); ?>

<?php else: ?>

    <?php echo $this->Html->link('en', array(
        'language' => 'en'
    )); ?>

<?php endif; ?>
