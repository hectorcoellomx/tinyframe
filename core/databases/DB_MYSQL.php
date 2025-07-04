<?php

namespace Core\Databases;

require_once './core/databases/DB.php'; 

class DB extends DB_CONFIG
{
    private static $instance;
    private $db = null;

    private function __construct($database_name = "")
    {
        $database_name = ($database_name == "") ? "mysql" : $database_name;
        $db_config = $this->get_config($database_name);

        $this->db = new \mysqli(
            $db_config['host'],
            $db_config['user'],
            $db_config['password'],
            $db_config['database']
        );

        if ($this->db->connect_error) {
            error_log("Error de conexión: " . $this->db->connect_error);
            throw new \Exception("Error al conectar con la base de datos.");
        }
    }

    public static function init($database_name = "")
    {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
        }
        return self::$instance;
    }

    private function get_param_types($params)
    {
        $types = '';
        foreach ($params as $param) {
            if (is_int($param)) {
                $types .= 'i';
            } elseif (is_float($param)) {
                $types .= 'd';
            } elseif (is_string($param)) {
                $types .= 's';
            } else {
                $types .= 'b'; // blob u otros
            }
        }
        return $types;
    }

    public function db_select_row($sql, $param = null)
    {
        return $this->db_select($sql, $param, false);
    }

    public function db_select($sql, $param = null, $list = true)
    {
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            error_log("Error al preparar consulta: " . $this->db->error);
            throw new \Exception("No se pudo preparar la consulta.");
        }

        if ($param) {
            $types = $this->get_param_types($param);
            $stmt->bind_param($types, ...$param);
        }

        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta: " . $stmt->error);
            throw new \Exception("No se pudo ejecutar la consulta.");
        }

        $result = $stmt->get_result();
        $output = $list ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();

        $stmt->close();
        return $output;
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

        if (!$stmt) {
            error_log("Error al preparar consulta: " . $this->db->error);
            throw new \Exception("No se pudo preparar la consulta.");
        }

        if ($param) {
            $types = $this->get_param_types($param);
            $stmt->bind_param($types, ...$param);
        }

        if (!$stmt->execute()) {
            error_log("Error al ejecutar consulta: " . $stmt->error);
            throw new \Exception("No se pudo ejecutar la consulta.");
        }

        $result = $lastid ? $this->db->insert_id : $stmt->affected_rows;

        $stmt->close();
        return $result;
    }

    public static function db_close()
    {
        if (self::$instance) {
            self::$instance->db->close();
            self::$instance->db = null;
            self::$instance = null;
        }
    }

    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}
