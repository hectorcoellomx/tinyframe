<?php

namespace Core;

use Core\Databases\DB;

class Route
{
    public static function loadMany(array $routes)
    {
        foreach ($routes as $index => $route) {
            if (!is_array($route) || count($route) < 3) {
                trigger_error("Invalid route definition at index $index", E_USER_ERROR);
                continue;
            }

            [$method, $path, $controller, $middleware] = array_pad($route, 4, []);

            self::register($method, $path, $controller, $middleware);
        }
    }

    public static function register($type, $route_pattern, $controller, $middlewares = [])
    {
        $get_route = (isset($_GET['route'])) ? $_GET['route'] : 'home';
        $get_route = (trim($get_route) === "home" || trim($get_route) === 'index.php' || trim($get_route) === '') ? '/' : "/" . trim($get_route);
        $get_route = ($get_route != "/" && $get_route[strlen($get_route) - 1] == "/") ? substr($get_route, 0, strlen($get_route) - 1) : $get_route;

        $finally_route_pattern = "/";
        

        if ($route_pattern != "/") {

            global $tinyframe_url_response;
            $tinyframe_url_response = [];

            $route_pattern_array = explode('/', $route_pattern);
            $slash = "";
            $pos = 0;

            foreach ($route_pattern_array as $route_single) {
                if ($route_single != "") {
                    $finally_route_pattern .= $slash . self::verify_param($route_single, $pos, $get_route);
                    $slash = "/";
                }
                $pos++;
            }
        }

        if ($finally_route_pattern == $get_route && strtolower($_SERVER['REQUEST_METHOD']) == strtolower($type)) {

            if (count($middlewares) > 0) {
                foreach ($middlewares as $middleware) {
                    if (!empty($middleware)) {
                        self::middleware($middleware);
                    }
                }
            }
            
            $controller[0] = 'App\\Controllers\\' . $controller[0];

            if (is_array($controller) &&  count($controller) == 2 && class_exists($controller[0]) && method_exists(new $controller[0], $controller[1])) {
                
                $object = new $controller[0];
                $method = $controller[1];
                
                $request = new \Core\Request(); 
                call_user_func_array([$object, $method], [$request]);

                DB::db_close();

                exit;
            }else{
                trigger_error("Invalid controller or method specified", E_USER_ERROR);
            }

        } else {
            global $tinyframe_nofound;
            $tinyframe_nofound = true;
        }
        
    }

    public static function middleware($name)
    {

        if (!preg_match('/^[A-Z][a-zA-Z]*$/', $name)) {
            trigger_error("Invalid middleware name format: '$name'. Must start with an uppercase letter and contain only letters.", E_USER_ERROR);
            return;
        }        

        $middlewareFilePath = './app/middlewares/' . $name . '.php';

        if (file_exists($middlewareFilePath)) {

            $middlewareClass = '\\App\\Middlewares\\' . $name;

            if (class_exists($middlewareClass)) {
                
                $middlewareInstance = new $middlewareClass();
                
                if (method_exists($middlewareInstance, 'run')) {
                    $middlewareInstance->run();
                } else {
                    trigger_error("The '$name' middleware does not have a 'run' method", E_USER_ERROR);
                }

            }else{
                trigger_error("Middleware class '$middlewareClass' does not exist", E_USER_ERROR);
            }

        }else {
            trigger_error("The middleware file does not exist '" .  $middlewareFilePath . "'", E_USER_ERROR);
        }

            
 
    }

    public static function verify_param($route_single, $pos, $get_route)
    {
        if ( substr($route_single, 0, 1) == "{" && substr($route_single, -1) == "}") {
            
            $value = "";
            $params = explode('/', $get_route);
            
            if (isset($params[$pos]) && $params[$pos] != "") {
                global $tinyframe_url_response;
                $value = htmlspecialchars($params[$pos], ENT_QUOTES, 'UTF-8');
                $var = substr($route_single, 1, -1);
                $tinyframe_url_response[$var] = $value;

            }

            return $value;

        } else {
            return $route_single;
        }
    }
}
