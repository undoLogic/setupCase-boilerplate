
<?php if(!empty($this->Identity->get('name'))): ?>
    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']); ?>" >Logout</a>
<?php else: ?>
    <a href=" <?= $this->Url->build(['controller' => 'Users', 'action' => 'login']); ?>">Login</a>
<?php endif; ?>

<?php
