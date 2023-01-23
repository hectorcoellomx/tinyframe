<?php

namespace Core\Databases;

use App\Config;

class DB
{
    private static $instance;
    private $db = null;
    private $database_conn = 'mysql';

    public function set_database_conn($database){
        $this->database_conn = $database;
    }
    
    private function __construct()
    {
        global $config;
        
        $db_config = $config->databases[$this->database_conn];
        $this->db = new \PDO("mysql:host=".$db_config['host'].";dbname=" . $db_config['database'], $db_config['user'], $db_config['password']);
        $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
              
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new DB();
        }
        return self::$instance;
    }

    public function db_select_row($sql, $param)
    {
        return $this->db_select($sql, $param, false);
    }

    public function db_select($sql, $param, $list = true)
    {
        $stmt = $this->db->prepare($sql); 
        $stmt->execute($param);
        $result = ($list) ? $stmt->fetchAll() : $stmt->fetch();
        return $result;
    }

    public function db_insert($sql, $param)
    {
        return $this->db_set($sql, $param);
    }

    public function db_insert_lastid($sql, $param)
    {
        return $this->db_set($sql, $param, true);
    }

    public function db_update($sql, $param)
    {
        return $this->db_set($sql, $param);
    }

    public function db_delete($sql, $param)
    {
        return $this->db_set($sql, $param);
    }

    public function db_set($sql, $param, $lastid = false)
    {

        $stmt = $this->db->prepare($sql); 
        $result = $stmt->execute($param);
        
        if($lastid){
            $result = $this->db->lastInsertId();
        }
        return $result;

    }

    public function close()
    {
        $this->db = null;
    }

}
