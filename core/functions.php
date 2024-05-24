<?php

use App\Config;

function redir($path="", $url=false){
    if(!$url){
        $config = new Config();
        header("Location: " . $config->base_url . $path);
        exit();
    }else{
        header("Location: " . $path);
        exit();
    }
    
}

function back(){
    return redir($_SERVER['HTTP_REFERER'], true);
}

function set_errors($errors){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['validator_errors'] = $errors;
}

function get_errors(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $errors = array();
    if(isset($_SESSION['validator_errors'])){
        $errors = $_SESSION['validator_errors'];
        unset($_SESSION['validator_errors']);
    }
    return  $errors;
}

function base($add=""){
    $config = new Config();
    return $config->base_url . $add;
}

function assets($add=""){
    $config = new Config();
    echo $config->base_url . 'assets/'. $add;
}

function input_json(){
    $data = file_get_contents("php://input");
    return json_decode($data, true);
}

function input($name, $type="all"){

    $value= NULL;
    
    if ( $type=="post" || $type=="put" || $type=="delete" || $type=="all" ) {
        $value = isset($_POST[$name]) ? $_POST[$name] : NULL;
        
        if($value==NULL){
            
            $data = file_get_contents("php://input");
            $data_decode = json_decode($data, true);

            if($data_decode==NULL){
                parse_str(file_get_contents("php://input"), $data_decode);
            }

            $value = isset($data_decode[$name]) ? $data_decode[$name] : NULL;
        }
    }

    if( $type=="get" || ($type=="all" && $value==NULL) ){
        $value = isset($_GET[$name]) ? $_GET[$name] : NULL;
    }

    if( $type=="url"  || ($type=="all" && $value==NULL) ){
        global $tinyapp_url_response;
        $value = isset( $tinyapp_url_response[$name] ) ? $tinyapp_url_response[$name] : NULL;
    }

    if( $type=="headers" || ($type=="all" && $value==NULL) ){
        $value = isset( getallheaders()[$name] ) ? getallheaders()[$name] : NULL;
    }
    
    return $value;
}

function exist_input($name){
    $value= false;
    
    if ( isset($_POST[$name]) || isset($_GET[$name]) ) {
        $value = true;
    }else{

        $data = file_get_contents("php://input");
        $data_decode = json_decode($data, true);

        if($data_decode==NULL){
            parse_str(file_get_contents("php://input"), $data_decode);
        }
        
        $value = isset($data_decode[$name]);

        if(!$value){
            global $tinyapp_url_response;
            if( isset( $tinyapp_url_response[$name] ) ){
                $value = true;
            }
        }

        if(!$value){
            $value = isset( getallheaders()[$name] );
        }
        
    }
    
    return $value;
}


