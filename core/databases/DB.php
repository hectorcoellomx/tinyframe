<?php 

namespace Core\Databases;

class DB_CONFIG 
{

    protected function get_config($name){
        
        $config = array('host' => "", 'user' => "", 'password' => "", 'database' => "", 'type' => 'mysql');

        $envFilePath = __DIR__ . '/../../.env';
            
        if (file_exists($envFilePath)){
            
            $lines = file($envFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); 
            if ($lines) {foreach ($lines as $line) {list($key, $value) = explode('=', $line, 2); $key = trim($key); $value = trim($value); if (!empty($key) && !isset($_ENV[$key])) {if ($value === '') {$_ENV[$key] = ''; } else {$_ENV[$key] = $value; } } } } 
            
            $type = $_ENV['DB_'.strtoupper($name).'_TYPE'];
            
            $config['type'] =          ($type=="mysql") ? 'mysql' : 'oracle';
            $config['host'] =          $_ENV['DB_'.strtoupper($name).'_HOST'];
            $config['user'] =          $_ENV['DB_'.strtoupper($name).'_USER'];
            $config['password'] =      $_ENV['DB_'.strtoupper($name).'_PASSWORD'];
            $config['database'] =      $_ENV['DB_'.strtoupper($name).'_NAME'];

            if($type=="oracle"){
                $config['port'] =          $_ENV['DB_'.strtoupper($name).'_PORT'];
                $config['service_name'] =  $_ENV['DB_'.strtoupper($name).'_SERVICE_NAME'];
            }

        }

        return $config;
    }

}