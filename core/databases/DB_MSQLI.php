<?php

namespace Core\Databases;

use App\Config;

class DB
{
    private static $instance;
    private $db = null;

    private function __construct($database_name = "")
    {
        global $config;

        if ($database_name != "") {
            $db_config = $config->databases[$database_name];
        } else {
            $db_config = reset($config->databases);
        }

        if ($db_config['type'] == "mysql") {
            $this->db = new \mysqli(
                $db_config['host'],
                $db_config['user'],
                $db_config['password'],
                $db_config['database']
            );

            if ($this->db->connect_error) {
                die("Error de conexión: " . $this->db->connect_error);
            }
        } else {
            // Código para conectar a Oracle si es necesario.
        }
    }

    public static function getInstance($database_name = "")
    {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
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

        if ($param) {
            $types = str_repeat('s', count($param)); // Assuming all params are strings
            $stmt->bind_param($types, ...$param);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $output = ($list) ? $result->fetch_all(MYSQLI_ASSOC) : $result->fetch_assoc();

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

        if ($param) {
            $types = str_repeat('s', count($param)); // Assuming all params are strings
            $stmt->bind_param($types, ...$param);
        }

        $result = $stmt->execute();

        if ($lastid) {
            $result = $this->db->insert_id;
        }

        $stmt->close();

        return $result;
    }

    public static function db_close()
    {
        if (self::$instance) {
            self::$instance->db->close();
            self::$instance->db = null;
        }
    }
}
