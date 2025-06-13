<?php 

namespace App\Services;

require_once './app/models/User.php';

use App\Models\User;

class AuthService {

    public function login($data){
        $email = $data['email'];
        $password = $data['password'];

        $user = new User();
        $login = $user->login($email, $password);

        return $login;
    }
}

