# CodeBlocks - Language: PHP
This is an automated file which is parsed by https://codeBlocks.setupcase.com 

*When modifying you MUST use proper markup syntax so that our systems can properly import and parse https://www.markdownguide.org/basic-syntax/*

- Title must be preceded by ### 
- Tags must be preceded by #### and each tag is separated by a comma, tags must NOT contain spaces
- Explanation describes what the code does must be preceded by **>**
- Code which the user will copy and paste into their project must be surrounded by **\```**
- Each block must be separated by \***

***
### BlockTitle: Foreach
#### Tags: PHP5.x, PHP7.x, PHP8.x
> A foreach allows to iterate through an array / list
#### CodeName: Foreach
```
foreach ($array as $key => $data) {
    //each loop
}
```
***
### BlockTitle: Routes 
#### Tags: CakePHP2.x
> Basic routes for all projects
#### CodeName: Routes
#### CodePath: /app/Config/routes.php
```
	Router::connect('/', array('controller' => 'pages', 'action' => 'index'));
	Router::connect('/add', array('rep' => true, 'controller' => 'Users', 'action' => 'add'));
```
***
### BlockTitle: Authentication
#### Tags: CakePHP2.x
> Authentication system will allow to use prefixes for different logon roles
#### CodeName: Components
#### CodePath: /app/Controller/AppController.php
#### CodeLocation: InArray = $components
```
# Basic variables to prepare
	 'Auth' => array(
            'loginAction' => array(
                'user' => false,
                'controller' => 'users', 'action' => 'login',
                //'plugin' => 'system'
            ),
            'authError' => 'Sorry you cannot see this', 'authenticate' => array(
                'Form' => array(
                    'fields' => array('username' => 'email')
                )
            ),
            'loginRedirect' => array(
                'client' => true,
                'plugin' => NULL, 'controller' => 'Pages', 'action' => 'dashboard',
                //'?' => array('newLayout' => 'd')
            )
        ),

```

#### CodeName: Auth Functions
#### CodePath: /app/Controller/AppController.php
#### CodeLocation: InClass = AppController
```
    //Authentication
    private function setupAuth() {

        $this->Auth->allow();

        $userInfo = $this->Auth->User();

        if(!empty($userInfo)){
            $this->set('isLoggedIn', true);
            $this->set('userInfo', $this->Auth->user());
            $this->set('group_id', $userInfo['group_id']);
            if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.client')) {
                $this->set('isClient', true);
                $this->set('isModerator', true);
            }else if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.staff')) {
                $this->set('isStaff', true);
                $this->set('isClient', true);
                $this->set('isModerator', true);
            }else if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.admin')) {
                $this->set('isAdmin', true);
                $this->set('isStaff', true);
                $this->set('isClient', true);
            }
        } else {
            $this->set('userInfo', false);
        }
        if (isset($this->params['admin'])) {
            if ($this->params['admin']) {
                $this->forceAdmin();
            }
        }
        if (isset($this->params['staff'])) {
            if ($this->params['staff']) {
                $this->forceStaff();
            }
        }
        if (isset($this->params['client'])) {
            if ($this->params['client']) {
                $this->forceClient();
            }
        }
    }
    function forceClient() {
        if ($this->isAdmin()) {} elseif ($this->isStaff()) {} elseif ($this->isClient()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function forceStaff() {
        if ($this->isAdmin()) {} elseif ($this->isStaff()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function forceAdmin() {
        if ($this->isAdmin()) {} else {
            $this->Session->setFlash('Access Required');
            $this->handleRedirect();
            exit;
        }
    }
    function isClient() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.client')) { return true; }
        return false;
    }
    function isStaff() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.staff')) { return true; }
        return false;
    }
    function isAdmin() {
        $userInfo = $this->Auth->user();
        if (!isset($userInfo['user_type_id'])) return false;
        if ($userInfo['user_type_id'] == Configure::read('Users.user_type_id.admin')) { return true; }
        return false;
    }
    function getUserId() {
        $user_info = $this->Auth->user();
        if(isset($user_info['id'])){ return $user_info['id']; }
        return false;
    }
    function getGroupId() {
        $user_info = $this->Auth->user();
        if(isset($user_info['group_id'])){ return $user_info['group_id']; }
        return false;
    }
    function handleRedirect() {
        $this->redirect('/login');
    }

```

#### CodeName: CallAuth
#### CodePath: /app/Controller/AppController.php
#### CodeLocation: InFunction = BeforeFilter
```
$this->setupAuth();
```

***
### BlockTitle: Validation
#### Tags: CakePHP2.x
> Validation rules are used to validate Form inputs before saving into Database.
#### CodeName: Validation
#### CodePath: /app/Model/className.php
#### CodeLocation: InArray = $validate
```

	var $validate = array(
        'login' => array(
            'alphaNumeric' => array(
                'rule' => 'alphaNumeric',
                'required' => true,
                'message' => 'Letters and numbers only'
            ),
            'between' => array(
                'rule' => array('lengthBetween', 5, 15),
                'message' => 'Between 5 to 15 characters'
            )
        ),
        'password' => array(
            'rule' => array('minLength', '8'),
            'message' => 'Minimum 8 characters long'
        ),
		'email' => 'email',
		'message' => array(
			'rule' => 'notEmpty',
			'message' => 'Enter your name',
			'allowEmpty' => false
		),
		'val' => array(
			'rule' => array('comparison', '==', 55),
			'message' => 'That answer is not correct: What do you get when you remove 5 from 60 ?',
			'allowEmpty' => false
		)
	);

```

***
### BlockTitle: Translation
#### Tags: CakePHP2.x
> Validation rules are used to validate Form inputs before saving into Database.
#### CodeName: Helper
#### CodePath: /app/View/Helper/

```php
<?php
App::import('Vendor', 'Translate_ven');
class TranslateHelper extends Translate_ven {}
```

#### CodeName: Usage In View
```php
<? = $translate->word('english'); ?>
```
#### CodeName: VendorFile
#### CodePath: /app/Vendor/Translate_ven.php

```php

	<?php
    class Translate_ven extends Object {

        var $helpers = array();

        var $currLang;

        var $softWareLang = 'eng';

        var $translateTable = array();

        var $file = false;

        var $rawCSV = false;

        public function setFileLocation($file) {
            $this->file = $file;
        }

        public function createCSV() {
            if (file_exists($this->file)) {
                //it is exits do nothing
            } else {
                //create
                $handle = fopen($this->file, "w");
                $this->saveFile(array('eng','spa','fra'));
            }
        }
        /**
         * @param $term
         * using the current language as specified in the app controller language
         * returns the correct term
         */
        public function word($termOrg) {


            if (!$this->file) {
                $this->file = APP.'Locale'.DS.'translate.csv';
            }

            $this->createCSV();

            $term = strtolower($termOrg);

            $this->setupLang();
            //pr ($this->softWareLang .' '.$this->currLang); exit;
            if ($this->softWareLang == $this->currLang) {
                return $termOrg;
            }

            $this->loadFile();
            //pr ($term);exit;
            //if our debug is set to 2 OR is setup server
            //add to our CSV file
            if ($this->shouldWeUpdateCsv()) {
                $this->ensureTermAdded($term);
            }

            //pr ($this->translateTable);exit;

            if (isset($this->translateTable[ $term ][$this->currLang])) {
                return $this->translateTable[ $term ][$this->currLang];
            } else {
                return $termOrg;//maybe hit a translation service here
            }
        }

        public function getRawCsv() {
            return array_map('str_getcsv', file($this->file));
        }

        private function loadFile(){

            if (!$this->rawCSV) {
                $this->rawCSV = array_map('str_getcsv', file($this->file));
                $keys = $this->rawCSV[0];
                foreach ($this->rawCSV as $index => $each) {

                    foreach ($keys as $keyIndex => $key) {

                        if (!isset($this->translateTable[ $each[0]])) {
                            $this->translateTable[ $each[0] ] = array();
                        }
                        if (!isset($this->translateTable[ $each[0]][ $keys [$keyIndex] ])) {
                            $this->translateTable[ $each[0] ][ $keys [$keyIndex] ] = array();
                        }

                        if (!isset($each[$keyIndex])) {
                            $this->translateTable
                            [ $each[0] ]
                            [ $keys[ $keyIndex ] ] =
                               'UNKNOWN';
                        } else {
                            $this->translateTable
                            [ $each[0] ]
                            [ $keys[ $keyIndex ] ] =
                                $each[$keyIndex];
                        }




                    }
                }
            } else {
                //already loaded
                return false;
            }

        }
        private function saveFile($line, $term = false) {

            if ($term) {
                //mark our translate table so we don't save again
                $this->translateTable[ $term ] = array();
            }

            $handle = fopen($this->file, "a");
            fputcsv($handle, $line); # $line is an array of string values here
            fclose($handle);
        }

        private function ensureTermAdded($term) {
            //get the csv

            //pr ($this->translateTable[ $term ]);
            //pr ($term);

            //pr ('trans');
            //pr ($this->translateTable);

            if (isset($this->translateTable[ $term ])) {
                //already have it
                //echo 'have it ';
                return true;
            } else {
                //echo 'save - ';
                $line = array($term,$term,$term);
                $this->saveFile($line, $term);
            }
        }

        private function shouldWeUpdateCsv() {
            $shouldWe = false;

            $debug = Configure::read('debug');
            if ($debug == 2) {
                $shouldWe = true;
            }

            if (!isset($_SERVER['HTTP_HOST'])) {
                //we are command line
                $_SERVER['HTTP_HOST'] = '';

            }
            $host = $_SERVER['HTTP_HOST'];

            $allowed = array('localhost', 'setup.updatecase.com');

            if (in_array($host, $allowed)) {
                $shouldWe = true;
            }

            return $shouldWe;
        }

        private function setupLang() {


            $currLang = Configure::read('currLang');

            //pr ($currLang);exit;
            if ($currLang == 'spa') {
                $this->currLang = 'spa';
            } elseif ($currLang == 'fre') {
                $this->currLang = 'fre';
            } else {
                $this->currLang = 'eng';
            }
        }

        private function getTermFromCSV() {
            //load csv
            //scan for the english term
            //return the term in the other language
            //if that term doesn't exist
        }





        /**
         * need all these since we are extending vendors from components / helpers
         */

        function beforeRender() {

        }

        function initialize() {

        }
        function startup() {

        }
        function shutdown() {

        }
        function beforeRenderFile() {

        }
        function afterRenderFile() {

        }
        function afterRender() {

        }
        function beforeLayout() {

        }
        function afterLayout() {

        }
        function beforeRedirect() {

        }
    }


```

***