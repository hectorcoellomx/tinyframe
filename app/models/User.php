<?php 

namespace App\Models;

use Core\Databases\DB;

class User {

    public function find($email){
        if($email=="test@example.com"){
            return array("email"=>"test@example.com", "password"=>"123");
        }else{
            return FALSE;
        }
    }

}