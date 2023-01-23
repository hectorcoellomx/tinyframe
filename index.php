<?php

    require './app/Config.php';
    use App\Config;
    
    require './core/databases/DB.php';

    $config = new Config();

    if($config->status_project=="pro"){
        ini_set('display_errors', 0);
        error_reporting(E_ALL ^ E_WARNING);
    }
    
    $tinyapp_test_url = $config->test_url;
    $tinyapp_nofound = false;
    $tinyapp_vars = null;
    $tinyapp_url_response = array();
    
    require './core/functions.php';
    require './core/Response.php';
    require './core/Validator.php';
    require './core/View.php';

    
    if($config->load_upload_files){
        require './core/File.php';
    }

    if($config->load_helper){
        require_once './app/helpers.php';
    }


    require './core/Route.php';
    require './app/routes.php';

    if($tinyapp_nofound){
        http_response_code(400);
        include('./core/pages/nofound.php');
        exit;
    }

    

?>