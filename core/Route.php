<?php

namespace Core;

use Core\Databases\DB;

class Route
{

    public static function register($type, $route_pattern, $controller, $middlewares = [])
    {

        $get_route = $_GET['route'];
        $get_route = (trim($get_route) == "index.php") ? '/' : "/" . trim($get_route);
        $get_route = ($get_route != "/" && $get_route[strlen($get_route) - 1] == "/") ? substr($get_route, 0, strlen($get_route) - 1) : $get_route;

        $finally_route_pattern = "/";
        $route_pattern_array = explode('/', $route_pattern);

        if ($route_pattern != "/") {

            global $tinyapp_url_response;
            $tinyapp_url_response = [];

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

        global $tinyapp_test_url;
        
        if ($tinyapp_test_url) {
            $match = ($finally_route_pattern == $get_route && strtolower($_SERVER['REQUEST_METHOD']) == $type) ? '#77dd77' : '#ff6961';
            echo "<div style='font-size: 15px;background-color: ".$match.";color: black;padding: 15px;margin-bottom: 2px;'>";
            echo "<strong>" . strtoupper($type) . "</strong> " . $route_pattern  . "<br><br><strong>Comparar:</strong><br>" . $finally_route_pattern  . "<br>" . $get_route . " (URL)";
            echo "</div>";
        }else{
            if ($finally_route_pattern == $get_route && strtolower($_SERVER['REQUEST_METHOD']) == $type) {

                if (count($middlewares) > 0) {
                    foreach ($middlewares as $middleware) {
                        self::middleware($middleware);
                    }
                }
    
                $object = new $controller[0];
                $method = $controller[1];
                $object->$method();

                DB::db_close();

                exit;

            } else {
                global $tinyapp_nofound;
                $tinyapp_nofound = true;
            }
        }
        
    }

    public static function middleware($name)
    {
        if ($name != "") {

            $middlewareFileName = ucfirst(strtolower($name)) . '.php';
            $middlewareFilePath = './app/middlewares/' . $middlewareFileName;

            if (preg_match('/^[a-zA-Z_]+\.php$/', $middlewareFileName)) {
                if (file_exists($middlewareFilePath)) {
                    require_once $middlewareFilePath;
                }else {
                    trigger_error("The middleware file does not exist '" .  $middlewareFilePath . "'", E_USER_ERROR);
                }
            }else{
                trigger_error("The file name for the middleware is invalid (Only letters and underscore) '" .  $middlewareFilePath . "'", E_USER_ERROR);
            }
            
        } else {
            exit;
        }
    }

    public static function verify_param($route_single, $pos, $get_route)
    {
        if ( substr($route_single, 0, 1) == "{" && substr($route_single, -1) == "}") {
            
            $value = "";
            $params = explode('/', $get_route);

            if (isset($params[$pos]) && $params[$pos] != "") {

                $value = $params[$pos];
                $var = substr($route_single, 1, -1);
                global $tinyapp_url_response;
                $tinyapp_url_response[$var] = $value;

            }

            return $value;

        } else {
            return $route_single;
        }
    }
}
