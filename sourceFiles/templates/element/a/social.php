
<?php if ($this->Lang->get() == 'en'): ?>
    <?php echo $this->Html->link('Français', ['language' => 'fr'], [
        'class' => $this->Lang->getActiveClass('fr')
    ]); ?>
<?php else: ?>
    <?php echo $this->Html->link('English', ['language' => 'en'], [
        'class' => $this->Lang->getActiveClass('en')
    ]); ?>
<?php endif; ?>






<li><a class="fa-facebook" href="https://www.facebook.com/undologic" target="_blank"></a></li>
<li><a class="fa-twitter" href="https://twitter.com/undologic" target="_blank"></a></li>
<li><a class="fa-instagram" href="https://www.instagram.com/undologic/" target="_blank"></a></li>
<li><a class="fa-linkedin" href="https://www.linkedin.com/company/undologic-inc-" target="_blank"></a></li>
