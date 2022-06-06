<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Utility\Text;

class UsersTable extends Table
{
    public function initialize(array $config):void
    {
        $this->addBehavior('Timestamp');
        $this->setTable('users');
        // associations
        $this->belongsTo('UserTypes', [
            'foreignKey' => 'user_type_id'
        ]);
    }

    function getUsers(){
        $users = $this->find('all');
        return($users->toArray());
    }

    function createUser($email, $password) {
        $user = $this->newEmptyEntity();

        $user->email = $email;
        $user->password = $password;
        $user->user_type_id = 111;

        if ($this->save($user)) {
            return $user->id;
        } else {
            return false;
        }
    }
    function getUserByEmail($email){
        $user = $this->find('all',['conditions' => [
            'AND' => [
                [ 'Users.email' => $email]
            ]
        ],
            'recursive' => -1,
            'contain' => ['UserTypes']
        ])->first();

        if(!empty($user)){

            return $user->toArray();
        }
        return false;
    }

    function saveUserPassword($email, $password) {
        $user = $this->find('all', [
            'conditions' => ['Users.email' => $email]
        ])->first();
        $user->password = $password;
        if ($this->save($user)) {
            return $user->toArray();
        } else {
            return false;
        }
    }

    function resetAddToken($email) {
        $user = $this->find('all', [
            'conditions' => ['Users.email' => $email]
        ])->first();
        $user->reset_token = Text::uuid();
        return $this->save($user);
    }
    function resetRemoveToken($email) {
        $user = $this->find('all', [
            'conditions' => ['Users.email' => $email]
        ])->first();
        $user->reset_token = '';
        return $this->save($user);
    }

    function getUserByEmailAndResetToken($email, $resetToken){
        $user = $this->find('all',['conditions' => [
            'AND' => [
                [ 'Users.email' => $email],
                [ 'Users.reset_token' => $resetToken]
            ]
        ],
            'recursive' => -1,
            'contain' => ['UserTypes']
        ])->first();

        if(!empty($user)){
            return $user->toArray();
        }
        return false;
    }

}// end
