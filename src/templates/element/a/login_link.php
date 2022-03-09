<?php if(!empty($this->Identity->get('name'))): ?>
    <a href=" <?= $webroot; ?>users/logout">Logout</a>
<?php else: ?>
    <a href=" <?= $webroot; ?>users/login">Login</a>
<?php endif; ?>

