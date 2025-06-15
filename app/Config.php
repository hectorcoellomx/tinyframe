<?php

namespace App;

class Config
{
    
    public $status_project = "dev"; // dev or pro
    public $base_url = "http://localhost/tinyframe/";

    public $databases_driver = "Mysqli"; // Mysqli (Mysql), OCI (Oracle), PDO (Mysql & Oracle)

    public $api_config = array(
        'default' => array(
            'origin' => "*",
            'methods' => "GET, PUT, PATCH, POST, DELETE",
            'headers' => "X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization",
            'content_type' => "application/json"
        )
    );

    public $load_session = false;
    public $session_id = "your_session_id";
    public $load_upload_files = false;
    public $test_routes = true;

    public function __construct()
    {
        $envFilePath = __DIR__ . '/../.env';
        if (file_exists($envFilePath)) {$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); if ($lines) {foreach ($lines as $line) {list($key, $value) = explode('=', $line, 2); $key = trim($key); $value = trim($value); if (!empty($key) && !isset($_ENV[$key])) {if ($value === '') {$_ENV[$key] = ''; } else {$_ENV[$key] = $value; } } } } }

        if (file_exists($envFilePath)){
            $this->status_project =                      $_ENV['STATUS_PROJECT'];
            $this->base_url =                            $_ENV['BASE_URL'];
            $this->databases_driver =                    $_ENV['DATABASES_DRIVER'];
            $this->session_id =                          $_ENV['SESSION_ID'];
        }
        
    }

}
