<?php


# Switch

// ln -sfn /home/undoweb/www/codeblocks/release1 /home/undoweb/www/codeblocks/current



$cmd = 'php /home/undoweb/deploy/deploy.php dev'
    . ' > /home/undoweb/deploy/logs/dev.log 2>&1 &';
exec($cmd);

//if (file_exists('/home/undoweb/deploy/lock/dev.lock')) {
//    $this->Flash->warning('A deployment is already running.');
//    return $this->redirect(['action' => 'status']);
//}



