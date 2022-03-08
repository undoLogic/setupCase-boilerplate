<?php
// src/Model/Table/ArticlesTable.php
namespace App\Model\Table;

use Cake\ORM\Table;

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

    function jsonAddUser($objData){
        $data = json_decode($objData, true);
       // pr($data); exit;

        $user = $this->newEmptyEntity();


            $user = $this->patchEntity($user, $data);

            if ($this->save($user)) {
              pr('saved'); exit;


            }else{
                pr('not saved'); exit;
            }




    }


}// end
