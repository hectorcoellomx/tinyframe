<?php 

namespace App\Models;

use Core\Databases\DB;

class User {

    public function login($email, $password){
        return ($email=="test@example.com" && $password == "123");
    }

}