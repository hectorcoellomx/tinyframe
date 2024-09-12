<?php

namespace Core\Databases;

use App\Config;

class DB
{
    private static $instance;
    private $db = null;

    private function __construct($database_name="")
    {
        global $config;

        if($database_name!=""){
            $db_config = $config->databases[$database_name];
        }else{
            $db_config = $config->databases["oracle"];
        }

        $conn_str = "//" . $db_config['host'] . ":" . $db_config['port'] . "/" . $db_config['service_name'];

        try {
            $this->db = oci_connect($db_config['user'], $db_config['password'], $conn_str, 'AL32UTF8');
            if (!$this->db) {
                $e = oci_error();
                throw new \Exception($e['message']);
            }
        } catch (\Exception $e) {
            echo "Error de conexión: " . $e->getMessage();
        }  
    }

    public static function init($database_name="") {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
        }
        return self::$instance;
    }

    public function db_select_row($sql, $param){
        return $this->db_select($sql, $param, false);
    }

    public function db_select($sql, $param, $list = true){
        $stmt = oci_parse($this->db, $sql);
        $this->bindParams($stmt, $param);
        oci_execute($stmt);

        $result = [];
        if ($list) {
            while ($row = oci_fetch_assoc($stmt)) {
                $result[] = $row;
            }
        } else {
            $result = oci_fetch_assoc($stmt);
        }
        oci_free_statement($stmt);
        return $result;
    }

    public function db_insert($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_insert_lastid($sql, $param){
        // Oracle doesn't have a direct method for getting the last inserted ID
        // This needs to be handled by a RETURNING clause in the SQL statement or other methods
        throw new \Exception("Method not implemented for Oracle");
    }

    public function db_update($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_delete($sql, $param){
        return $this->db_set($sql, $param);
    }

    public function db_set($sql, $param, $lastid = false){
        $stmt = oci_parse($this->db, $sql);
        $this->bindParams($stmt, $param);
        $result = oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
        oci_free_statement($stmt);

        if($lastid){
            throw new \Exception("Method not implemented for Oracle");
        }
        return $result;
    }

    private function bindParams($stmt, $param) {
        foreach ($param as $key => $value) {
            oci_bind_by_name($stmt, $key, $param[$key]);
        }
    }

    public static function db_close(){
        if (self::$instance) {
            oci_close(self::$instance->db);
            self::$instance->db = null;
        }
    }
}
