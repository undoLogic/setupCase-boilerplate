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
```
foreach ($array as $key => $data) {
    //each loop
}
```
***
### Title: Routes 
#### Tags: CakePHP2.x
> Basic routes for all projects
#### Path: /app/Config/routes.php
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