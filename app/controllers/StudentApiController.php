<?php 

namespace App\Controllers;

use Core\Response;

require_once './app/models/App.php';

class StudentApiController extends Response{

    public function index(){
        
        $students = array(
            array('id' => 100, "name" => 'Mary Jones' ),
            array('id' => 101, "name" => 'David Williams' ),
            array('id' => 102, "name" => 'Matt Smith' ),
            array('id' => 103, "name" => 'Cris Brown' )
        );
        
        $data = array( 'success' => true, 'data' => $students, 'message' => "" );
        return $this->json($data, 200);

    }
  

}




?>