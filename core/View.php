<?php 

namespace Core;

class View {

    public function set_header($code, $content_type)
    {
        header('Content-Type: ' . $content_type);
        http_response_code($code);
    }

    public static function get($_name, $_data=null){

        global $tinyapp_vars;

        if($tinyapp_vars==null){
            $tinyapp_vars = $_data;
        }
        
        if(is_array($tinyapp_vars)){
            extract($tinyapp_vars);
        }

        include('./app/views/'.$_name.'.php');
        
    }

    
}
