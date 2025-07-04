<?php

namespace Core\Databases;

class DB extends DB_CONFIG
{
    private static $instance;
    private $db = null;

    private function __construct($database_name = "")
    {
        $database_name = ($database_name == "") ? "sqlite" : $database_name;
        $db_config = $this->get_config($database_name);

        try {
            $this->db = new \SQLite3($db_config['path']);
        } catch (\Exception $e) {
            error_log("Error al conectar SQLite: " . $e->getMessage());
            throw new \Exception("Error al conectar con la base de datos SQLite.");
        }
    }

    public static function init($database_name = "")
    {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
        }
        return self::$instance;
    }

    public function db_select_row($sql, $param = null)
    {
        return $this->db_select($sql, $param, false);
    }

    public function db_select($sql, $param = null, $list = true)
    {
        try {
            $stmt = $this->prepare($sql, $param);
            $result = $stmt->execute();

            $data = [];
            while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
                $data[] = $row;
            }

            $stmt->close();
            $result->finalize();

            return $list ? $data : ($data[0] ?? null);
        } catch (\Exception $e) {
            error_log("Error en SELECT SQLite: " . $e->getMessage());
            throw new \Exception("Error al ejecutar la consulta SQLite.");
        }
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
        try {
            $stmt = $this->prepare($sql, $param);
            $stmt->execute();
            $stmt->close();

            return $lastid ? $this->db->lastInsertRowID() : $this->db->changes();
        } catch (\Exception $e) {
            error_log("Error en escritura SQLite: " . $e->getMessage());
            throw new \Exception("Error al ejecutar la consulta SQLite.");
        }
    }

    private function prepare($sql, $params)
    {
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            throw new \Exception("No se pudo preparar la consulta.");
        }

        if ($params) {
            foreach ($params as $i => $value) {
                $index = $i + 1;
                $paramName = ":param$index"; // usamos nombre, aunque SQLite permite ? también

                if (is_int($value)) {
                    $stmt->bindValue($index, $value, SQLITE3_INTEGER);
                } elseif (is_float($value)) {
                    $stmt->bindValue($index, $value, SQLITE3_FLOAT);
                } elseif (is_null($value)) {
                    $stmt->bindValue($index, null, SQLITE3_NULL);
                } else {
                    $stmt->bindValue($index, $value, SQLITE3_TEXT);
                }
            }
        }

        return $stmt;
    }

    public static function db_close()
    {
        if (self::$instance && self::$instance->db) {
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
