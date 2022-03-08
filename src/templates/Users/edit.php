<div ng-app="myApp" ng-controller="usersCtrl">
    <form name="myForm "ng-submit="sendForm()">
        <input type="text"class="form-control" ng-model="data.name" name="data.name" required>


<?= $this->Form->submit('Add',[]); ?>
</form>
    <script id="webroot" data-name="<?= $webroot;?>" src="<?= $webroot;?>js/a/users.js"></script>
