<?php 

namespace App\Controllers;

require_once './app/models/App.php';
require_once './app/services/AuthService.php';

use Core\Controller;
use Core\Request;

use App\Models\App;
use App\Services\AuthService;

class HomeController extends Controller {

    private $service;

    public function __construct()
    {
        $this->service = new AuthService();
    }
    
    public function index(Request $req){

        $app = new App();
        $message = $app->message();

        $logged = $req->input('logged');
        $version = get_version();

        $data = array(
            'app' => "TinyApp",
            'message' => $message, 
            'version' => $version, 
            'logged' => $logged
        );

        $this->view('partials/header', $data);
        $this->view('home');
        $this->view('partials/footer');

    }

    public function access(){

        $data = array('app' => "TinyApp");
        
        $this->view('partials/header', $data);
        $this->view('login');
        $this->view('partials/footer');

    }

    public function login(Request $req){

        $req->validate([
            [ 'email', [ 'email', 'trim' ] ],
            [ 'password', [ 'min(1)', 'trim' ] ],
        ]);

        $login = $this->service->login($req->all());
        
        if($login){
            redir('?logged=1');
        }
        
        set_errors(['Claves incorrectas']);
        redir('login');
        

    }

}




?>