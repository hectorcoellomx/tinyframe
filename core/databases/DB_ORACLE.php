<?php

namespace Core\Databases;

class DB extends DB_CONFIG
{
    private static $instance;
    private $db = null;

    private function __construct($database_name = "")
    {
        $database_name = ($database_name == "") ? "oracle" : $database_name;
        $db_config = $this->get_config($database_name);

        $conn_string = "(DESCRIPTION =
            (ADDRESS = (PROTOCOL = TCP)(HOST = {$db_config['host']})(PORT = {$db_config['port']}))
            (CONNECT_DATA =
                (SERVICE_NAME = {$db_config['service_name']})
            )
        )";

        $this->db = @oci_connect(
            $db_config['user'],
            $db_config['password'],
            $conn_string,
            $db_config['charset'] ?? 'AL32UTF8'
        );

        if (!$this->db) {
            $e = oci_error();
            error_log("Error de conexión OCI: " . $e['message']);
            throw new \Exception("Error al conectar con la base de datos Oracle.");
        }
    }

    public static function init($database_name = "")
    {
        if (!self::$instance) {
            self::$instance = new DB($database_name);
        }
        return self::$instance;
    }

    private function bind_params($stmt, $params)
    {
        foreach ($params as $i => $value) {
            $paramName = ":param" . $i;
            if (is_int($value)) {
                oci_bind_by_name($stmt, $paramName, $params[$i], -1, SQLT_INT);
            } elseif (is_float($value)) {
                oci_bind_by_name($stmt, $paramName, $params[$i], -1, SQLT_FLT);
            } else {
                oci_bind_by_name($stmt, $paramName, $params[$i], -1, SQLT_CHR);
            }
        }
    }

    public function db_select_row($sql, $param = null)
    {
        $result = $this->db_select($sql, $param, false);
        return $result;
    }

    public function db_select($sql, $param = null, $list = true)
    {
        $stmt = @oci_parse($this->db, $this->parse_named_sql($sql, $param));

        if (!$stmt) {
            $e = oci_error($this->db);
            $ociMsg = isset($e['message']) ? trim($e['message']) : 'Error OCI desconocido.';
            error_log("Error al preparar OCI: " . $ociMsg);
            throw new \Exception("No se pudo preparar la consulta. Oracle: " . $ociMsg);
        }

        if ($param) {
            $this->bind_params($stmt, $param);
        }

        if (!@oci_execute($stmt)) {
            $e = oci_error($stmt);
            $ociMsg = isset($e['message']) ? trim($e['message']) : 'Error OCI desconocido.';
            error_log("Error al ejecutar OCI: " . $ociMsg);
            throw new \Exception("No se pudo ejecutar la consulta. Oracle: " . $ociMsg);
        }

        $data = [];
        while ($row = oci_fetch_assoc($stmt)) {
            $row = array_change_key_case($row, CASE_LOWER); // Convert keys to lowercase
            $data[] = $row;
        }

        oci_free_statement($stmt);

        return $list ? $data : ($data[0] ?? null);
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
        if ($lastid) {
            $sql .= " RETURNING ID INTO :last_insert_id";
        }

        $stmt = @oci_parse($this->db, $this->parse_named_sql($sql, $param));

        if (!$stmt) {
            $e = oci_error($this->db);
            $ociMsg = isset($e['message']) ? trim($e['message']) : 'Error OCI desconocido.';
            error_log("Error al preparar OCI: " . $ociMsg);
            throw new \Exception("No se pudo preparar la consulta. Oracle: " . $ociMsg);
        }

        if ($param) {
            $this->bind_params($stmt, $param);
        }

        $last_insert_id = 0;
        if ($lastid) {
            oci_bind_by_name($stmt, ":last_insert_id", $last_insert_id, 32, SQLT_INT);
        }

        if (!@oci_execute($stmt, OCI_COMMIT_ON_SUCCESS)) {
            $e = oci_error($stmt);
            $ociMsg = isset($e['message']) ? trim($e['message']) : 'Error OCI desconocido.';
            error_log("Error al ejecutar OCI: " . $ociMsg);
            throw new \Exception("No se pudo ejecutar la consulta. Oracle: " . $ociMsg);
        }

        $result = $lastid ? $last_insert_id : oci_num_rows($stmt);

        oci_free_statement($stmt);
        return $result;
    }

    public static function db_close()
    {
        if (self::$instance && self::$instance->db) {
            oci_close(self::$instance->db);
            self::$instance->db = null;
            self::$instance = null;
        }
    }

    public function __destruct()
    {
        if ($this->db) {
            oci_close($this->db);
        }
    }

    // Convierte ? a :param0, :param1...
    private function parse_named_sql($sql, $params)
    {
        if (!$params) return $sql;
        $paramCount = substr_count($sql, '?');
        for ($i = 0; $i < $paramCount; $i++) {
            $sql = preg_replace('/\?/', ':param' . $i, $sql, 1);
        }
        return $sql;
    }
}
