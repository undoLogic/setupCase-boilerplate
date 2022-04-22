<div ng-app="myApp" ng-controller="usersCtrl">
<div class="container-fluid" >
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <h4>Users - Admin </h4>
            </div>
            <div class="col-lg-6 text-right">

                <a class="btn btn-primary" href="<?= $webroot ; ?>Users/edit">Add AngularJs</a>&nbsp;
                <a class="btn btn-primary" href="<?= $webroot ; ?>Users/uploadFile">Upload File</a>&nbsp;
                <?= $this->Html->link('Export Users', array(
                    'controller' => 'Users',
                    'action' => 'export',
                ), array('class' => 'btn btn-primary')); ?>

                <?= $this->Html->link('Add',[
                    //'language' => $current_language,
                  'action' => 'add', 'new'
]);
                ?>
            </div>
        </div>

    </div>
            <?php if(!empty($users)): ?>
            <div class="card-header">
                <div class="row">
                <div class="col-lg-3">Actions</div>
                <div class="col-lg-3">Name</div>
                <div class="col-lg-3">Email</div>
                <div class="col-lg-3">Telephone</div>
                </div>
            </div>
    <div class="card-body">
             <div class="row">
                <?php foreach($users as $user): ?>


                        <div class="col-lg-3">
                            <?= $this->Html->link('Edit', [
                                'action' => 'edit', $user['id']
                            ]) ;

                            ?></div>
                        <div class="col-lg-3"><?= $user['name'] ; ?></div>
                        <div class="col-lg-3"><?= $user['email'] ; ?></div>
                        <div class="col-lg-3"><?= $user['telephone'] ; ?></div>
            <?php endforeach; ?>
             </div>
            <?php endif; // not empty use ?>




</div>
</div>
</div>
    <script id="webroot" data-name="<?= $webroot;?>" src="<?= $webroot;?>js/a/users.js"></script>


