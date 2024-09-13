<?php
    
    $tinyapp_version = "1.2.0";

    require './app/Config.php';
    use App\Config;

    $tinyapp_config = new Config();

    $tinyapp_bd_driver = ($tinyapp_config->databases_driver!=null) ? strtoupper($tinyapp_config->databases_driver) : $tinyapp_config->databases_driver;
    $tinyapp_status_project = ($tinyapp_config->status_project!=null) ? strtoupper($tinyapp_config->status_project) : $tinyapp_config->status_project;

    if($tinyapp_bd_driver=="PDO"){
        require './core/databases/DB_PDO.php';
    }elseif($tinyapp_bd_driver=="OCI"){
        require './core/databases/DB_OCI.php';
    }else{
        require './core/databases/DB_MYSQLI.php';
    }

    if($tinyapp_status_project=="pro"){
        ini_set('display_errors', 0);
        error_reporting(E_ALL ^ E_WARNING);
    }else{
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }
    
    $tinyapp_test_url = $tinyapp_config->test_url;
    $tinyapp_nofound = false;
    $tinyapp_vars = null;
    $tinyapp_url_response = array();
    
    require './core/functions.php';

    if($tinyapp_config->load_session){
        require './core/Session.php';
    }

    require './core/Response.php';
    require './core/Validator.php';
    require './core/View.php';

    
    if($tinyapp_config->load_upload_files){
        require './core/File.php';
    }

    require_once './app/helpers.php';
    require './core/Route.php';
    require './app/routes.php';

    if($tinyapp_nofound){
        http_response_code(400);
        include('./core/pages/nofound.php');
        exit;
    }

    

?>