<?php

namespace Core;

class File
{


    public static function upload($name, $destination = "", $validations = [])
    {

        $file = $_FILES[$name];

        $fileName = $file['name'];
        $fileTempName = $file['tmp_name'];
        $fileError = $file['error'];

        $fileType = $file['type'];
        $fileSize = $file['size'];


        $valid_max_size = isset($validations['max_size']) ? $validations['max_size'] : 0;
        $valid_types = isset($validations['allowed_types']) ? explode("|",  $validations['allowed_types']) : [];

        //$validations['file_name'] = explode(",",  $validations['file_name']);

        $size_aproveed = ( $fileSize >= $valid_max_size );
        $type_aproveed = $valid_types == [] || in_array($fileType, $valid_types);

        $error = "";
        $moved = 0;

        if ($fileError == 0) {

            if (!$size_aproveed) {
                $error = "El archivo excede el tamaño máximo permitido";
            } elseif (!$type_aproveed) {
                $error = "El tipo de archivo no es permitido";
            } else {

                $fileNameNew = ( isset($validations['file_name']) && trim($validations['file_name'])!="" )  ? $validations['file_name'] : uniqid('', true);
                $fileNameNew .= "." . strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $destination = ($destination != "") ? "upload/" . $destination . "/" : "upload/";

                if (!file_exists($destination)) {
                    mkdir($destination, 0777);
                }

                $fileDestination = $destination . $fileNameNew;

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
