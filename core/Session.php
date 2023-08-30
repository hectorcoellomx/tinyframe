<?php

namespace Core;

class Session {
    
    private $id= 'sessionid';

    public function __construct($id="") {
        session_start();     

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

    function logout($redirect=''){
        unset($_SESSION[$this->id]);

        if($redirect!=''){
            redir($redirect);
        }
    }
}

/*

Example

use Core\Session;


$session = new Session();
$data_session = array( "id"=> 100, "username"=> 'Hector');
$session->create($data_session);
$session->set_data("username", "Hector Coello");
$id = $session->get_data("id");
$validate = $session->validate("login");
$session->logout();

 */
