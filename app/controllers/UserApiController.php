<?php 

namespace App\Controllers;

use Core\Controller;
use Core\Request;

class UserApiController extends Controller {

    public function __construct(){

    }

    public function list(){
        $data = array( 
                'success' => false, 
                'data' => null, 
                'message' =>  [ [ "id" => 1, "name" => "John Doe" ], [ "id" => 2, "name" => "Jane Doe" ] ]
            );
        return $this->json($data, 200);
    }

    public function create(){
        $data = array( 
                'success' => false, 
                'data' => null, 
                'message' =>  "User created successfully"
            );
        return $this->json($data, 200);
    }

}




?>