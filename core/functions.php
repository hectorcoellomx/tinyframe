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

function env($name){
    $_ENV = [];
    $envFilePath = __DIR__ . '/../.env';
    if (file_exists($envFilePath)) {$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); if ($lines) {foreach ($lines as $line) {list($key, $value) = explode('=', $line, 2); $key = trim($key); $value = trim($value); if (!empty($key) && !isset($_ENV[$key])) {if ($value === '') {$_ENV[$key] = ''; } else {$_ENV[$key] = $value; } } } } }
    if(substr($name, 0, 3)!="DB_"){
        return isset($_ENV[$name]) ? $_ENV[$name] : NULL;
    }else{
        return "For security reasons, you cannot obtain environment variables (.env) that start with DB_";
    }
    
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
function route($type, $url, $controller, $middlewares = []) {
    global $tinyframe_routes, $tinyframe_group_middlewares;

    $all_middlewares = array_unique(array_merge($tinyframe_group_middlewares, $middlewares));

    $tinyframe_routes[] = [$type, $url, $controller, $all_middlewares];
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

function route_group(array $middlewares, callable $routes_definition) {
    global $tinyframe_group_middlewares;

    $original = $tinyframe_group_middlewares;
    $tinyframe_group_middlewares = $middlewares;

    $routes_definition();

    $tinyframe_group_middlewares = $original;
}


function set_errors($errors){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['validator_errors'] = $errors;
}








