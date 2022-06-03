<?php



namespace App\Model\Entity;

use Authentication\PasswordHasher\DefaultPasswordHasher; // Add this line
use Cake\ORM\Entity;

class User extends Entity
{

    protected $_accessible =[
        '*'=>true,
        'id'=>true,

    ];


    // Add this method
    protected function _setPassword(string $password) : ?string
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }else{
           return false;
    }
}


}// end
