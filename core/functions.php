<?php

function assets($add=""){
    global $tinyframe_config;
    echo $tinyframe_config->base_url . 'assets/'. $add;
}

function back(){
    return redir($_SERVER['HTTP_REFERER'], true);
}

function base($add=""){
    global $tinyframe_config;
    return $tinyframe_config->base_url . $add;
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

function get_version(){
    global $tinyframe_version;
    return $tinyframe_version;
}

function redir($path, $external=false){
    if(!$external){
        global $tinyframe_config;
        header("Location: " . $tinyframe_config->base_url . $path);
        exit();
    }else{
        header("Location: " . $path);
        exit();
    }
    
}

function route($type, $url, $controller, $middlewares = []){
    global $tinyframe_routes;
    $tinyframe_routes[] = [$type, $url, $controller, $middlewares];
}

function route_get($url, $controller, $middlewares = []) {
    route('get', $url, $controller, $middlewares);
}

function route_post($url, $controller, $middlewares = []) {
    route('post', $url, $controller, $middlewares);
}

function route_put($url, $controller, $middlewares = []) {
    route('put', $url, $controller, $middlewares);
}

function route_patch($url, $controller, $middlewares = []) {
    route('patch', $url, $controller, $middlewares);
}

function route_delete($url, $controller, $middlewares = []) {
    route('delete', $url, $controller, $middlewares);
}

function set_errors($errors){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['validator_errors'] = $errors;
}








