<?php

namespace Core;

class File
{

    private static $MIME_TO_EXT = [
        'image/jpeg'                                                                  => 'jpg',
        'image/png'                                                                   => 'png',
        'image/gif'                                                                   => 'gif',
        'image/webp'                                                                  => 'webp',
        'image/bmp'                                                                   => 'bmp',
        'application/pdf'                                                             => 'pdf',
        'text/plain'                                                                  => 'txt',
        'text/csv'                                                                    => 'csv',
        'application/zip'                                                             => 'zip',
        'application/json'                                                            => 'json',
        'video/mp4'                                                                   => 'mp4',
        'video/webm'                                                                  => 'webm',
        'audio/mpeg'                                                                  => 'mp3',
        'audio/wav'                                                                   => 'wav',
        'application/msword'                                                          => 'doc',
        'application/vnd.ms-excel'                                                    => 'xls',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'    => 'docx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'          => 'xlsx',
    ];

    private static $DANGEROUS_EXTENSIONS = [
        'php', 'php3', 'php4', 'php5', 'php7', 'phtml', 'phar',
        'asp', 'aspx', 'jsp', 'py', 'rb', 'pl', 'sh', 'bash',
        'exe', 'bat', 'cmd', 'ps1', 'htaccess', 'htpasswd',
    ];

    private static function extensionFromMime(string $mime): ?string
    {
        return self::$MIME_TO_EXT[$mime] ?? null;
    }

    public static function upload($name, $destination = "", $options = [])
    {
        if (!isset($_FILES[$name])) {
            return [
                'status' => false,
                'url' => '',
                'message' => 'Archivo no encontrado en la solicitud.'
            ];
        }

        if (empty($options['allowed_types'])) {
            return [
                'status' => false,
                'url' => '',
                'message' => 'Debe especificar los tipos de archivo permitidos (allowed_types).'
            ];
        }

        $file = $_FILES[$name];

        $fileTempName = $file['tmp_name'];
        $fileError    = $file['error'];
        $fileSize     = $file['size'];

        $mime_real = (new \finfo(FILEINFO_MIME_TYPE))->file($fileTempName);

        $valid_max_size = $options['max_size'] ?? 0;
        $valid_types    = explode('|', $options['allowed_types']);

        $size_ok = ($valid_max_size == 0 || $fileSize <= $valid_max_size);
        $type_ok = in_array($mime_real, $valid_types, true);

        $error = "";
        $moved = 0;

        if ($fileError == 0) {

            if (!$size_ok) {
                $error = "El archivo excede el tamaño máximo permitido";
            } elseif (!$type_ok) {
                $error = "El tipo de archivo no es permitido";
            } else {

                // La extensión se deriva del MIME real, nunca del nombre provisto por el cliente
                $ext = self::extensionFromMime($mime_real);
                if ($ext === null) {
                    return [
                        'status'  => false,
                        'url'     => '',
                        'message' => 'Tipo de archivo no reconocido: ' . $mime_real,
                    ];
                }

                if (in_array($ext, self::$DANGEROUS_EXTENSIONS, true)) {
                    return [
                        'status'  => false,
                        'url'     => '',
                        'message' => 'El tipo de archivo no está permitido por razones de seguridad.',
                    ];
                }

                $baseName    = (isset($options['file_name']) && trim($options['file_name']) !== '')
                    ? pathinfo(trim($options['file_name']), PATHINFO_FILENAME)
                    : uniqid('', true);
                $fileNameNew = $baseName . '.' . $ext;

                $destination = ($destination != "") ? "upload/" . $destination . "/" : "upload/";

                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                    // Bloquea la ejecución de scripts en el directorio de subidas
                    $htaccess = $destination . '.htaccess';
                    if (!file_exists($htaccess)) {
                        file_put_contents($htaccess, "php_flag engine off\nOptions -ExecCGI\nRemoveHandler .php .php3 .php4 .php5 .php7 .phtml .phar .asp .aspx .jsp .py .pl .sh\nAddType text/plain .php .php3 .php4 .php5 .php7 .phtml .phar\n");
                    }
                }

                $fileDestination = $destination . $fileNameNew;

                $overwrite = $options['overwrite'] ?? true;

                if (!$overwrite && file_exists($fileDestination)) {
                    return [
                        'status' => false,
                        'url' => '',
                        'message' => 'Ya existe un archivo con ese nombre.'
                    ];
                }

                $moved = move_uploaded_file($fileTempName, $fileDestination);
                $error = ($moved != 1) ? 'No se ha podido guardar el archivo "' . $name . '"' : '';
            }
        } else {
            $error = "Error al subir el archivo";
        }


        $res = array(
            'status' => ($moved == 1),
            'url' => ($moved == 1) ? $fileDestination : '',
            'message' => $error
        );

        return $res;
    }

    public static function delete($filePath)
    {
        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return [
                    'status' => true,
                    'message' => 'El archivo ha sido eliminado exitosamente.'
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'No se pudo eliminar el archivo.'
                ];
            }
        } else {
            return [
                'status' => false,
                'message' => 'El archivo no existe.'
            ];
        }
    }

}
