var WEBROOT=document.getElementById("webroot").getAttribute("data-name");

var app=angular.module('myApp',[]);
app.controller('usersCtrl',function($scope,$http,$window,$location){
    $scope.test = 'test123';


    $scope.sendForm=function (){
        console.log('data');
        console.log($scope.data);
        addUser();
    }// send form

    function addUser(){
        var objData = JSON.stringify($scope.data);
        console.log('formdata');
        console.log(objData);
        var URL = WEBROOT+'Users/jsonAddUser/';
        console.log('URL: '+URL);
        $http.post(URL, objData).then(function (response) {
            if(response){
                console.log('user added');
            }else{
                console.log('ERROR');
            }

        });

    }// end of addUser

});
