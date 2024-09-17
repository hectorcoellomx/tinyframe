<?php 

namespace Core;


class Response {

    public function json($data, $code, $config_name="default")
    {
        global $tinyapp_config;
        $api_config = $tinyapp_config->api_config[$config_name];

        header("Access-Control-Allow-Origin: " . $api_config['origin']);
        header('Access-Control-Allow-Methods: ' . $api_config['methods']);
        header("Allow: " . $api_config['methods']);
        header("Access-Control-Allow-Headers: " . $api_config['headers']); 
        header('Content-Type: ' . $api_config['content_type']);

        http_response_code($code);
        echo json_encode($data);
    }

    
}
