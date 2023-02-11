<?php 

namespace App\Controllers;

require_once './app/models/App.php';

use Core\Validator;
use Core\View;

use App\Models\App;

class HomeController{
    

    public function index(){

        $app = new App();
        $message = $app->message();

        $logged = input('logged');

        $data = array(
            'app' => "TinyApp", 
            'message' => $message,
            'logged' => $logged
        );

        View::get('partials/header', $data);
        View::get('home');
        View::get('partials/footer');

    }

    public function access(){

        $data = array('app' => "TinyApp");
        

        View::get('partials/header', $data);
        View::get('login');
        View::get('partials/footer');

    }

    public function login(){

        Validator::check([
            [ 'email', [ 'email', 'trim' ] ],
            [ 'password', [ 'min(1)', 'trim' ] ],
        ]);

        // $username = input('username');
        // $password = input('password');
        
        redir('?logged=1');

    }

}




?>