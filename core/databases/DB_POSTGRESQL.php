<?php

namespace Core\Databases;

require_once './core/databases/DB.php';

class DB extends DB_CONFIG
{
    private static $instance;
    private $db = null;

    private function __construct($database_name = "")
    {
        $database_name = ($database_name == "") ? "pgsql" : $database_name;
        $config = $this->get_config($database_name);

        $conn_str = sprintf(
            "host=%s port=%s dbname=%s user=%s password=%s",
            $config['host'],
            $config['port'],
            $config['database'],
            $config['user'],
            $config['password']
        );

        $this->db = @pg_connect($conn_str);

        if (!$this->db) {
            error_log("Error al conectar con PostgreSQL.");
            throw new \Exception("Error al conectar con la base de datos PostgreSQL.");
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
            $query_name = $this->make_query_name($sql);
            $sql = $this->convert_placeholders($sql);

            if (!pg_prepare($this->db, $query_name, $sql)) {
                throw new \Exception("No se pudo preparar la consulta.");
            }

            $result = pg_execute($this->db, $query_name, $param ?? []);

            if (!$result) {
                throw new \Exception("No se pudo ejecutar la consulta.");
            }

            $data = pg_fetch_all($result) ?: [];

            return $list ? $data : ($data[0] ?? null);
        } catch (\Exception $e) {
            error_log("Error en SELECT PostgreSQL: " . $e->getMessage());
            throw new \Exception("Error al ejecutar la consulta.");
        }
    }

    public function db_insert($sql, $param)
    {
        return $this->db_set($sql, $param, false);
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
            $query_name = $this->make_query_name($sql);
            $sql = $this->convert_placeholders($sql);

            if (!pg_prepare($this->db, $query_name, $sql)) {
                throw new \Exception("No se pudo preparar la consulta.");
            }

            $result = pg_execute($this->db, $query_name, $param ?? []);

            if (!$result) {
                throw new \Exception("No se pudo ejecutar la consulta.");
            }

            if ($lastid) {
                $res = pg_query($this->db, "SELECT LASTVAL() AS id");
                $row = pg_fetch_assoc($res);
                return $row['id'] ?? null;
            }

            return pg_affected_rows($result);
        } catch (\Exception $e) {
            error_log("Error en SET PostgreSQL: " . $e->getMessage());
            throw new \Exception("Error al ejecutar la consulta.");
        }
    }

    private function convert_placeholders($sql)
    {
        $count = substr_count($sql, '?');
        for ($i = 1; $i <= $count; $i++) {
            $sql = preg_replace('/\?/', "\${$i}", $sql, 1);
        }
        return $sql;
    }

    private function make_query_name($sql)
    {
        return 'stmt_' . md5($sql);
    }

    public static function db_close()
    {
        if (self::$instance && self::$instance->db) {
            pg_close(self::$instance->db);
            self::$instance->db = null;
            self::$instance = null;
        }
    }

    public function __destruct()
    {
        if ($this->db) {
            pg_close($this->db);
        }
    }
}
