<?php

function assets($add=""){
    global $tinyframe_config;
    echo $tinyframe_config->base_url . 'assets/'. $add;
}

function back(){
    global $tinyframe_config;
    $referer = $_SERVER['HTTP_REFERER'] ?? '';

    if ($referer !== '') {
        $referer_host = parse_url($referer, PHP_URL_HOST);
        $base_host    = parse_url($tinyframe_config->base_url, PHP_URL_HOST);

        if ($referer_host !== null && $referer_host === $base_host) {
            return redir($referer, true);
        }
    }

    return redir('/');
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
        if(!isset($_ENV[$name])){
            throw new \Exception("Error: The requested '".$name."' environment variable does not exist in the .env file");
            exit(1);
        }
        return $_ENV[$name];
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

function csrf_token(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field(){
    echo '<input type="hidden" name="_csrf_token" value="' . csrf_token() . '">';
}

function csrf_verify(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $token = $_POST['_csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
    if ($token === null ||empty($_SESSION['_csrf_token']) || !hash_equals($_SESSION['_csrf_token'], $token)) {
        http_response_code(403);
        echo json_encode(['error' => 'Invalid CSRF token']);
        exit;
    }
}

function rate_limit(string $key = '', int $maxAttempts = 5, int $windowSeconds = 60, int $blockSeconds = 300): bool
{
    if ($key === '') {
        $key = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
    if (!\Core\RateLimiter::attempt($key, $maxAttempts, $windowSeconds, $blockSeconds)) {
        $retry = \Core\RateLimiter::retryAfter($key);
        http_response_code(429);
        echo json_encode(['error' => 'Too many attempts. Try again in ' . $retry . ' seconds.']);
        exit;
    }
    return true;
}

function rate_limit_clear(string $key = ''): void
{
    if ($key === '') {
        $key = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
    \Core\RateLimiter::clear($key);
}






