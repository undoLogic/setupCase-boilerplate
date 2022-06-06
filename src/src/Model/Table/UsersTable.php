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
        $user = $this->find('all')->first();
        $user->password = $password;
        return $this->save($user);
    }

    function getUser($email, $password){
        $user = $this->find('all',['conditions' => [
            'AND' => [
                [ 'Users.email' => $email],
                [ 'Users.password' => $password],
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

//    function exportUsers()
//    {
//        $rows = [];
//        $fields_to_include = ['name', 'user_type_id', 'email'];
//
//        $users = $this->find('all', [
//            //'conditions' => array(),
//            'fields' => ['user_type_id', 'name', 'email'],
//            'recursive' => -1,
//            'contain' => ['UserTypes']
//
//            //'limit' => 5
//        ])->toArray();
//
//
//        foreach ($users as $key => $user) {
//
//            if (!empty($user)) {
//                $row = $fields_to_include;
//                $rows[0]=$row;
//                $row = [];
//                foreach($fields_to_include as $field) {
//
//                    $row[$field] = $user[$field];
//
//
//                    // add userType name instead of id
////                if(isset($user['UserTypes'])){
////                    if(!empty($user['UserTypes'])) {
////                    }
////                    $row['product_type'] = $user['UserType']['name'];
////                    unset($row['user_type_id']);
////                }}
//                    // remove unwanted fields from row
//                    // unset($row['id'], $row['password'], $row['created'], $row['modified']);
//
//
//
//                }
//
//                $rows[] = $row;
//            }// if not empty answer
//        }// end foreach users
//       // pr ($rows);exit;
//        $this->downloadCsv($rows, 'Users-'.date('Y-m-d').'.csv');
//            pr('ok'); exit;
//            return true;
//
//       // return $rows;
//
//    }// END OF FUNCTION export users
//
//    function downloadCsv($rows, $filename) {
//
//        // /download start
//        $f = fopen('php://memory', 'w');
//
//        $columnNames = array();
//        if (!empty($rows)) {
//            //We only need to loop through the first row of our result
//            //in order to collate the column names.
//            $columnNames = $rows[0];
//            unset($rows[0]);
//
//        }
//
//        fputcsv($f, $columnNames);
//
//        //pr ($rows);exit;
//        foreach ($rows as $rowName => $row) {
//
//            //pr($row); exit;
//            fputcsv($f, $row);
//
//            //pr ($rows);exit;
//        }
//
//        fseek($f, 0);
//
//        header('Content-Encoding: UTF-8');
//        header('Content-type: text/csv; charset=UTF-8');
//        header('Content-Type: text/csv');
//        header('Content-Disposition: attachment; filename="' . $filename . '";');
//        echo "\xEF\xBB\xBF"; // UTF-8 BOM
//        fpassthru($f);
//        fclose($f);
//
//
//    }
//
//
//
//    function jsonAddUser($objData){
//        $data = json_decode($objData, true);
//       // pr($data); exit;
//
//        $user = $this->newEmptyEntity();
//
//
//            $user = $this->patchEntity($user, $data);
//
//            if ($this->save($user)) {
//              pr('saved'); exit;
//
//
//            }else{
//                pr('not saved'); exit;
//            }
//
//
//
//
//    }


}// end
