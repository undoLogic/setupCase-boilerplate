# CodeBlocks - Language: JavaScript (JS)
This is an automated file which is parsed by https://codeBlocks.setupcase.com 

*When modifying you MUST use proper markup syntax so that our systems can properly import and parse https://www.markdownguide.org/basic-syntax/*

- Title must be preceded by ### 
- Tags must be preceded by #### and each tag is separated by a comma, tags must NOT contain spaces
- Explanation describes what the code does must be preceded by **>**
- Code which the user will copy and paste into their project must be surrounded by **\```**
- Each block must be separated by \***

***
### Title: Angular Template File
#### Tags: angularJS
> A template file allowing to start a new AngularJS module
```
# Create a file which is accessible to your webroot eg pageJS.js

var WEBROOT = document.getElementById('webroot').getAttribute('data-name'); //allows to reference the webroot passed from cakePHP

var app = angular.module('myApp', []);
app.controller('pagesCtrl', function ($scope, $http, $window, $location, $interval) { //pagesCtrl can be changed to the name of your app i.e. salesCtrl

    // use strict
    $scope.dealerinit = []; //keep data in this object
    $scope.dealerTextarea = "loading..."; //any variables that are visible in the view can be referenced here
    var PAGE_ID = false; //these variables are only available within the object

    //initial load
    loadPages();


    function loadCommonVars() { //get data set in the view

        //DROPDOWN = $('#DROPDOWNID').find(":selected").val();
        PAGE_ID = $('#variable_id').val();
    }



    $scope.loadPages = function() { //this allows a button in the view to load our function calls in this object
        //alert('loading dealers');
        loadPages();
    };

    function loadPages() {

        loadCommonVars();

        loadingColour();

        var objData = {
            // page: setupSessionSearch('page'),
        };

        let URL = WEBROOT + 'staff/Pages/jsonIndex/'+PAGE_ID+'/';
        console.log(URL);
        $http.post(URL, objData).then(function (response) {

            console.log(response.data);
            $scope.data = response.data;

            loadingComplete();
        });
    }

    /* Loading */
    function loadingColour() {
        $('#entireTable').attr('class', 'table responsive loading');
    }
    function loadingComplete() {
        $('#entireTable').attr('class', 'table responsive loaded');
    }


    //handle getting logged out - requires an action in the Users controller
    var interval = $interval(isLoggedIn, 10000);
    function isLoggedIn() {
        let URL = WEBROOT + 'Users/isLoggedIn/';
        console.log(URL);
        $http.get(URL).then(function (response) {
            console.log(response);
            if (response.data == '440 Login Time-out') {
                alert('You Have been Logged out - Please login again');
                // Simulate an HTTP redirect:
                window.location.replace(WEBROOT+"Users/login");
            }
            //$scope.dealers = response.data;
        });
    }


});
```



***
### BlockTitle: Auto-submit search only if user stops typing
#### Tags: JS
> When a user types in a search into a search box the submit process will only happen after the user stops typing. This ensures you only have a single submit to the database and still keep the user-experience clean and fluid.

#### CodeName: Javascript file
```javascript

var searchTimer;

function onChangeTextBox() {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(function() {
        clearTimeout(searchTimer);
        queryDatabase();
    }, 100);
}

function queryDatabase() {
    alert('query the db here...');
    //here you would query the database
    // it only runs a single time after the user stops typing
}
```

#### CodeName: Html Search Input 
```html
<input type="text" placeholder="Filter products..." onkeydown="onChangeTextBox();"/>
```
***