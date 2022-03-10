<div ng-app="myApp" ng-controller="usersCtrl">
<div class="container-fluid" >
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-lg-6">
                <h4>Users </h4>
            </div>
            <div class="col-lg-6 text-right">
                <a class="btn btn-primary" href="<?= $webroot ; ?>Users/add">Add User</a>&nbsp;
                <a class="btn btn-primary" href="<?= $webroot ; ?>Users/edit">Add AngularJs</a>&nbsp;
                <a class="btn btn-primary" href="<?= $webroot ; ?>Users/downloadImage">Download</a>&nbsp;
            </div>
        </div>

    </div>
            <?php if(!empty($users)): ?>
            <div class="card-header">
                <div class="row">
                <div class="col-lg-4">Name</div>
                <div class="col-lg-4">Email</div>
                <div class="col-lg-4">Telephone</div>
                </div>
            </div>
    <div class="card-body">
             <div class="row">
                <?php foreach($users as $user): ?>


                        <div class="col-lg-4"><?= $user['name'] ; ?></div>
                        <div class="col-lg-4"><?= $user['email'] ; ?></div>
                        <div class="col-lg-4"><?= $user['telephone'] ; ?></div>
            <?php endforeach; ?>
             </div>
            <?php endif; // not empty use ?>




</div>
</div>
</div>
    <script id="webroot" data-name="<?= $webroot;?>" src="<?= $webroot;?>js/a/users.js"></script>


