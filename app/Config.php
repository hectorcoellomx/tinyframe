<?php

namespace App;

class Config
{
    
    public $status_project = 'dev'; 

    public $base_url = 'http://localhost/tinyapp/';

    public $databases = array(

        'mysql' => array(
            'host' => "localhost",
            'user' => "root",
            'password' => "",
            'database' => "tinyapp",
            'type' => 'mysql'
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



}
