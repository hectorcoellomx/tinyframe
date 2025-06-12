<?php 

namespace App\Controllers;

require_once './app/models/App.php';

use Core\Request;
use Core\Validator;
use Core\View;

use App\Models\App;

class HomeController{
    

    public function index(Request $req){

        $app = new App();
        $message = $app->message();

        $logged = $req->input('logged');
        $version = get_version();
        
        //vd($version);

        $data = array(
            'app' => "TinyApp",
            'message' => $message, 
            'version' => $version, 
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