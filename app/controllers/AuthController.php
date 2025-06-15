<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Request;

use App\Services\AuthService;

class AuthController extends Controller {

    public function __construct()
    {
        $this->service = new AuthService();
    }

    public function access(){

        $data = array('app' => "TinyFrame");
        
        $this->renderView('login', $data, 'layout/main');
    
    }

    public function login(Request $req){

        $req->verify([
            [ 'email', [ 'email', 'trim' ] ],
            [ 'password', [ 'min(1)', 'trim' ] ],
        ]);

        $login = $this->service->login($req->all());
        
        if($login){
            redir('?logged=1');
        }else{
            set_errors(['Claves incorrectas']);
            redir('login');
        }

    }

}




?>