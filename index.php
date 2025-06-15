<?php
    
    $tinyframe_version = "2.0.0";

    //require_once __DIR__ . '/vendor/autoload.php';

    spl_autoload_register(function ($class) {
        
        $classPath = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $file = __DIR__ . '/' . $classPath . '.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            trigger_error("No se encontró el archivo para la clase $class en $file", E_USER_ERROR);
        }
        
    });
    
    require './app/Config.php';
    use App\Config;

    $tinyframe_config = new Config();

    $tinyframe_bd_driver = ($tinyframe_config->databases_driver!=null) ? strtoupper($tinyframe_config->databases_driver) : $tinyframe_config->databases_driver;
    $tinyframe_status_project = ($tinyframe_config->status_project!=null) ? strtoupper($tinyframe_config->status_project) : $tinyframe_config->status_project;

    if($tinyframe_bd_driver=="PDO"){
        require './core/databases/DB_PDO.php';
    }elseif($tinyframe_bd_driver=="OCI"){
        require './core/databases/DB_OCI.php';
    }else{
        require './core/databases/DB_MYSQLI.php';
    }

    if($tinyframe_status_project=="pro"){
        ini_set('display_errors', 0);
        error_reporting(E_ALL ^ E_WARNING);
    }else{
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }
    
    $tinyframe_nofound = false;
    $tinyframe_url_response = array();
    
    require './core/functions.php';

    if($tinyframe_config->load_session){
        require './core/Session.php';
    }

    require './core/Controller.php';
    require './core/Validator.php';
    require './core/Request.php';

    if($tinyframe_config->load_upload_files){
        require './core/File.php';
    }

    require_once './app/helpers.php';
    require_once './core/Route.php';
    require_once './app/routes.php';

    if($tinyframe_nofound){
        http_response_code(400);
        include('./core/pages/nofound.php');
        exit;
    }

?>