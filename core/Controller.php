<?php 

namespace Core;


class Controller {

    protected $service;

    public function json($data, $code, $config_name="default")
    {
        global $tinyframe_config;
        $api_config = $tinyframe_config->api_config[$config_name];

        header("Access-Control-Allow-Origin: " . $api_config['origin']);
        header('Access-Control-Allow-Methods: ' . $api_config['methods']);
        header("Allow: " . $api_config['methods']);
        header("Access-Control-Allow-Headers: " . $api_config['headers']); 
        header('Content-Type: ' . $api_config['content_type']);

        http_response_code($code);
        echo json_encode($data);
    }

    public function renderView(string $view, $data = null, string $layout = '') {

        if(is_array($data) && count($data)>0){
            extract($data, EXTR_SKIP);
        }

        ob_start();
        include("./app/views/{$view}.php");
        $content_view = ob_get_clean();

        if ($layout) {
            $layoutPath = "./app/views/{$layout}.php";

            if (!file_exists($layoutPath)) {
                throw new \Exception("Layout no encontrado: $layout");
            }

            include($layoutPath);
        } else {
            echo $content_view;
        }
    }


    
}
