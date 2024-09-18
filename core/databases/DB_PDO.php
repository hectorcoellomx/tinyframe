<?php

namespace Core\Databases;

require_once './core/databases/DB.php';

class DB extends DB_CONFIG
{
    private static $instance;
    private $db = null;

    private function __construct($database_name="")
    {
        $database_name = ($database_name=="") ? "mysql" : $database_name;
        $db_config = $this->get_config($database_name);

        if($db_config['type']=="mysql"){
            $dsn = "mysql:host=".$db_config['host'].";dbname=" . $db_config['database'];
        }else{
            $dsn = "oci:dbname=//" . $db_config['host'] . ":" . $db_config['port'] . "/" . $db_config['service_name'];
        }

        try {
            $this->db = new \PDO($dsn, $db_config['user'], $db_config['password']);
            $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
        }  
    }

    public static function init($database_name="") {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
        }
        return self::$instance;
    }

    public function db_select_row($sql, $param=null){
        return $this->db_select($sql, $param, false);
    }

    public function db_select($sql, $param=null, $list = true){
        $stmt = $this->db->prepare($sql); 
        $stmt->execute($param);
        $result = ($list) ? $stmt->fetchAll(\PDO::FETCH_ASSOC) : $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function db_insert($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_insert_lastid($sql, $param){
        return $this->db_set($sql, $param, true);
    }

    public function db_update($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_delete($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_set($sql, $param, $lastid = false){
        $stmt = $this->db->prepare($sql); 
        $result = $stmt->execute($param);
        
        if($lastid){
            $result = $this->db->lastInsertId();
        }
        return $result;
    }

    public static function db_close(){
        if (self::$instance) {
            self::$instance->db = null;
        }
    }
}
