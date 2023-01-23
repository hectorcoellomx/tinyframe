<?php 

namespace App\Controllers;

require_once './app/models/App.php';
require_once './app/models/User.php';

use Core\Validator;
use Core\View;
//use Core\File;

use App\Models\App;
use App\Models\User;

class HomeController{
    

    public function index(){

        $app = new App();
        $message = $app->message();

        $data = array('app' => "TinyApp", 'message' => $message);

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

        // [ 'photo', [ 'file' ] ],
        
        $username = input('username'); // GET or POST or URL Param
        $password = input('password');

        /*$upload = File::upload('photo', 'photos', [ 'max_size' => 514319, 'allowed_types' => "image/jpeg|pdf" ]);

        if(!$upload['status']){
            set_errors(array($upload['message']));
            back();
        }*/
        
        redir('dashboard');

    }

    public function dashboard(){

        
        //Example using models
        //$user = new User();
        //$insert = $user->insert("Camila Santos");
        //$users = $user->list(1);
        //$user2 = $user->single(1);
        //$users2 = $user->list(1);

        //$update = $user->update(1, "Cristine Williams");
        //$delete = $user->delete($insert);
        //var_dump($users);     

        $data = array('app' => "TinyApp");

        View::get('partials/header', $data);
        View::get('dashboard');
        View::get('partials/footer');

    }

  

}




?>