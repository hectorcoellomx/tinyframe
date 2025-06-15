<?php

namespace Core;

class File
{


    public static function upload($name, $destination = "", $options = [])
    {
        if (!isset($_FILES[$name])) {
            return [
                'status' => false,
                'url' => '',
                'message' => 'Archivo no encontrado en la solicitud.'
            ];
        }

        $file = $_FILES[$name];

        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $fileError = $file['error'];

        $fileSize = $file['size'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_real = finfo_file($finfo, $fileTempName);
        finfo_close($finfo);

        $valid_max_size = $options['max_size'] ?? 0;
        $valid_types = isset($options['allowed_types']) ? explode("|", $options['allowed_types']) : [];

        $size_ok = ( $valid_max_size == 0 || $fileSize <= $valid_max_size );
        $type_ok = (empty($valid_types) || in_array($mime_real, $valid_types));

        $error = "";
        $moved = 0;

        if ($fileError == 0) {

            if (!$size_ok) {
                $error = "El archivo excede el tamaño máximo permitido";
            } elseif (!$type_ok) {
                $error = "El tipo de archivo no es permitido";
            } else {

                $fileNameNew = ( isset($options['file_name']) && trim($options['file_name'])!="" )  ? $options['file_name'] : uniqid('', true);
                $fileNameNew .= "." . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $destination = ($destination != "") ? "upload/" . $destination . "/" : "upload/";

                if (!is_dir($destination)) {
                    mkdir($destination, 0777, true);
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
