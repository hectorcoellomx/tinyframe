<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Request;

class HomeController extends Controller {

    public function __construct(){

    }
    
    public function index(Request $req){

        $logged = $req->input('logged');

        $data = array(
            'version' => get_version(), 
            'logged' => $logged
        );

        $this->view('partials/header', $data);
        $this->view('home');
        $this->view('partials/footer');

    }

}




?>