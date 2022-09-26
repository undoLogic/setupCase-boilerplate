


<?php if ($this->Lang->get() == 'en'): ?>
    <?php echo $this->Html->link('Français', ['language' => 'fr'], [
        'class' => $this->Lang->getActiveClass('fr')
    ]); ?>
<?php else: ?>
    <?php echo $this->Html->link('English', ['language' => 'en'], [
        'class' => $this->Lang->getActiveClass('en')
    ]); ?>
<?php endif; ?>



