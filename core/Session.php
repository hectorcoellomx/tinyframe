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
            global $tinyframe_config;
            $this->id = $tinyframe_config->session_id;
        }
    }

    function start($data){
        $_SESSION[$this->id] = $data;
    }

    function check($redirect = '') {
        $exists = isset($_SESSION[$this->id]);
        
        if (!$exists && $redirect !== '') {
            redir($redirect);
            exit;
        }

        return $exists ? $_SESSION[$this->id] : false;
    }

    function get($key=""){   
        $data = isset($_SESSION[$this->id]) ? $_SESSION[$this->id] : [];
        return ($key == "") ? $data : ((isset($data[$key])) ? $data[$key] : null);
    }

    function set($key, $value){   
        $data = isset($_SESSION[$this->id]) ? $_SESSION[$this->id] : [];
        $data[$key] = $value;
        $_SESSION[$this->id] = $data;      
    }

    function exists() {
        return isset($_SESSION[$this->id]);
    }

    function destroy($redirect = '') {
        if (session_status() !== PHP_SESSION_NONE) {
            // Limpia las variables de sesión
            session_unset();

            // Elimina la cookie de sesión (buena práctica)
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }

            // Destruye la sesión
            session_destroy();
        }

        if ($redirect !== '') {
            redir($redirect);
            exit;
        }
    }


}

