<?php 

namespace App\Services;

use App\Models\User;

class AuthService {

    public function login($data){
        $email = $data['email'];
        $password = $data['password'];

        $user = new User();
        $userData = $user->find($email);

        return ($userData && ($userData["email"]==$email && $userData["password"]==$password) );
    }
}

