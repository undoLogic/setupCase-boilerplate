<div ng-app="myApp" ng-controller="usersCtrl">
    <form name="myForm "ng-submit="sendForm()">
        <div class="row">
            <!-- name -->
            <div class="col-lg-4">
                <label>Name</label>
                <input type="text"class="form-control" ng-model="data.name" name="data.name" required>
            </div>

            <!-- email -->
            <label>Email</label>
            <div class="col-lg-4">
                <input type="text"class="form-control" ng-model="data.email" name="data.email" required>
            </div>

            <!-- telephone -->
            <label>Telephone</label>
            <div class="col-lg-4">
                <input type="text"class="form-control" ng-model="data.telephone" name="data.telephone" required>
            </div>
            <div class="col-lg-12">
                <?= $this->Form->submit('Add',[]); ?>
            </div>
        </div>




</form>
    <script id="webroot" data-name="<?= $webroot;?>" src="<?= $webroot;?>js/a/users.js"></script>
