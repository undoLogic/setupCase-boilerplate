<ul class="navbar-nav ms-auto">
    <li>
        <?php if ($this->Auth->isLoggedIn()): ?>
            LOGGED IN (<?php echo $this->Html->link('Logout', '/logout'); ?>)
        <?php else: ?>
            NOT logged in (<?php echo $this->Html->link('Login', '/login'); ?>)
        <?php endif; ?>
    </li>

    <li class="nav-item">
        <a class="nav-link" target="_blank" href="https://www.setupcase.com/">SetupCase.com</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" target="_blank" href="https://store.setupcase.com/">Store</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" target="_blank" href="https://github.com/undoLogic/setupCase-boilerplate">GitHub</a>
    </li>
</ul>
