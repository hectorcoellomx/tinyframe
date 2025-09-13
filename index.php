<?php

    /**
     * TinyFrame es un framework de uso gratuito, propiedad de Héctor de Jesús Coello Gómez (hector_m3@live.com.mx).
     */

    //require_once __DIR__ . '/vendor/autoload.php';
    
    $tinyframe_version = "2.0.0";

    spl_autoload_register(function ($class) {
        $baseDir = __DIR__;
        $classPath = str_replace("\\", DIRECTORY_SEPARATOR, $class);
        $parts = explode(DIRECTORY_SEPARATOR, $classPath);
        $classFile = array_pop($parts);
        $dirs = array_map('strtolower', $parts);

        $file = $baseDir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $dirs) . DIRECTORY_SEPARATOR . $classFile . '.php';

        $realFile = realpath($file);

        if ($realFile && strpos($realFile, $baseDir) === 0) {
            require_once $realFile;
        } else {
            trigger_error("No se encontró o no es válido el archivo para la clase $class", E_USER_ERROR);
        }
    });

    require './app/Config.php';
    use App\Config;

    $tinyframe_config = new Config();

    $tinyframe_bd_driver = ($tinyframe_config->databases_driver!=null) ? strtoupper($tinyframe_config->databases_driver) : $tinyframe_config->databases_driver;
    $tinyframe_status_project = ($tinyframe_config->status_project!=null) ? strtoupper($tinyframe_config->status_project) : $tinyframe_config->status_project;
    
    if($tinyframe_status_project=="pro"){
        ini_set('display_errors', 0);
        error_reporting(E_ALL ^ E_WARNING);
    }else{
        ini_set('display_errors', 1);
        error_reporting(E_ALL);
    }

    require './core/databases/DB_CONFIG.php';
    
    if($tinyframe_bd_driver=="ORACLE"){
        require './core/databases/DB_ORACLE.php';
    }else{
        require './core/databases/DB_MYSQL.php';
    }  
    
    $tinyframe_nofound = false;
    $tinyframe_url_response = array();
    $tinyframe_routes = [];
    $tinyframe_group_middlewares = [];

    require_once './app/helpers.php';
    require './core/functions.php';

    require './core/Controller.php';
    require './core/Request.php';
    require_once './core/Route.php';
    
    require_once './app/routes.php';
    Core\Route::loadMany($tinyframe_routes);

    if($tinyframe_nofound){
        http_response_code(400);
        include('./core/pages/nofound.php');
        exit;
    }


?>