<?php

namespace Core;

class Session {
    
    private $id= 'sessionid';

    public function __construct($id="") {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }     

        if($id!=""){
            $this->id = $id;
        }else{
            global $config;
            $this->id = $config->session_id;
        }
    }

    function create($data){
        $_SESSION[$this->id] = $data;
    }

    function validate($redirect=''){   
        if($redirect==""){
            return isset($_SESSION[$this->id]) ? $_SESSION[$this->id] : false;
        }else{  
            redir($redirect);
        }
    }

    function get_data($key=""){   
        $data = $_SESSION[$this->id];
        return ($key == "") ? $data : ((isset($data[$key])) ? $data[$key] : null);
    }

    function set_data($key, $value){   
        $data = $_SESSION[$this->id];
        $data[$key] = $value;
        $_SESSION[$this->id] = $data;      
    }

    function delete($redirect=''){
        unset($_SESSION[$this->id]);

        if($redirect!=''){
            redir($redirect);
        }
    }
}

/*

Example

use Core\Session;

// Crear una sesión
$session = new Session();
$data_session = array( "id"=> 100, "username"=> 'Hector');
$session->create($data_session);

// Cambiar datos de sesión
$session = new Session();
$session->set_data("username", "Hector Coello");

// Obtener datos de sesión
$session = new Session();
$id = $session->get_data("id");

// Validar sesión
$session = new Session();
$validate = $session->validate();
$validate = $session->validate("login");

// Eliminar sesión
$session->delete();

 */
