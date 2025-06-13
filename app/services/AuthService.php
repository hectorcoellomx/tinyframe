<?php 

namespace App\Services;

class AuthService {

    public function login($data){
        $email = $data['email'];
        $password = $data['password'];

        return ($email=="admin@gmail.com" && $password == "123");
    }
}

