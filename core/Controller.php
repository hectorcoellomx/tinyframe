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

    private function resolveViewPath(string $name, string $label): string
    {
        // Rechaza cualquier secuencia de path traversal o caracteres fuera de lo permitido
        if (!preg_match('/^[a-zA-Z0-9_\-\/]+$/', $name)) {
            throw new \Exception("Nombre de $label inválido: $name");
        }

        $base     = realpath('./app/views');
        $resolved = realpath($base . '/' . $name . '.php');

        if ($resolved === false || strpos($resolved, $base . DIRECTORY_SEPARATOR) !== 0) {
            throw new \Exception("$label no encontrado o fuera del directorio permitido: $name");
        }

        return $resolved;
    }

    public function renderView(string $view, $data = null, string $layout = '') {

        if(is_array($data) && count($data)>0){
            extract($data, EXTR_SKIP);
        }

        $viewPath = $this->resolveViewPath($view, 'Vista');

        ob_start();
        include($viewPath);
        $content_view = ob_get_clean();

        if ($layout) {
            $layoutPath = $this->resolveViewPath($layout, 'Layout');
            include($layoutPath);
        } else {
            echo $content_view;
        }
    }


    
}
