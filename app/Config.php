<?php

namespace App;

class Config
{
    
    public $status_project = 'dev'; // dev or pro

    public $base_url = 'http://localhost/tinyapp/';

    public $databases = array(
        'mysql' => array(
            'host' => "localhost",
            'user' => "root",
            'password' => "",
            'database' => "tinyapp",
            'type' => 'mysql'
        ), 
        'oracle' => array(
            'host' => "localhost",
            'port' => "1521",
            'user' => "root",
            'password' => "",
            'service_name' => "pdbsaucetux",
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

    public $load_helper = false;
    public $load_upload_files = false;

    public $test_url = false;
    
    public $session_login = "login";
    public $session_home = "home";



}
