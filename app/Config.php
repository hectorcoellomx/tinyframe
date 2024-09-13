<?php

namespace App;

class Config
{
    
    public $status_project = "dev"; // dev or pro
    public $base_url = "http://localhost/tinyapp/";

    public $databases_driver = "Mysqli"; // Mysqli (Mysql), OCI (Oracle), PDO (Mysql & Oracle)

    public $databases = array(
        'mysql' => array(
            'host' => "",
            'user' => "",
            'password' => "",
            'database' => "",
            'type' => 'mysql'
        ), 
        'oracle' => array(
            'host' => "",
            'port' => "",
            'user' => "",
            'password' => "",
            'service_name' => "",
            'type' => 'oracle'
        )
    );
    

    public $api_config = array(

        'default' => array(
            'origin' => "*",
            'methods' => "GET, PUT, POST, DELETE",
            'headers' => "X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Authorization",
            'content_type' => "application/json"
        )

    );

    public $load_session = false;
    public $session_id = "your_secret_session_id_here";

    public $load_upload_files = false;

    public $test_url = false;


    public function __construct()
    {
        $envFilePath = __DIR__ . '/../.env';
        if (file_exists($envFilePath)) {$lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); if ($lines) {foreach ($lines as $line) {list($key, $value) = explode('=', $line, 2); $key = trim($key); $value = trim($value); if (!empty($key) && !isset($_ENV[$key])) {if ($value === '') {$_ENV[$key] = ''; } else {$_ENV[$key] = $value; } } } } }

        if (file_exists($envFilePath)){
            
            $this->status_project =                      $_ENV['STATUS_PROJECT'];
            $this->base_url =                            $_ENV['BASE_URL'];
            $this->session_id =                          $_ENV['SESSION_ID'];
            $this->databases_driver =                    $_ENV['DATABASES_DRIVER'];

            $this->databases['mysql']['host'] =          $_ENV['DB_MYSQL_HOST'];
            $this->databases['mysql']['user'] =          $_ENV['DB_MYSQL_USER'];
            $this->databases['mysql']['password'] =      $_ENV['DB_MYSQL_PASSWORD'];
            $this->databases['mysql']['database'] =      $_ENV['DB_MYSQL_NAME'];

            $this->databases['oracle']['host'] =         $_ENV['DB_ORACLE_HOST'];
            $this->databases['oracle']['port'] =         $_ENV['DB_ORACLE_PORT'];
            $this->databases['oracle']['user'] =         $_ENV['DB_ORACLE_USER'];
            $this->databases['oracle']['password'] =     $_ENV['DB_ORACLE_PASSWORD'];
            $this->databases['oracle']['service_name'] = $_ENV['DB_ORACLE_SERVICE_NAME'];

        }
        

    }

}
