<?php

namespace Core;

class Validator
{

    public static function check($rules, $redirect = true)
    {

        $errors = array();

        // allows_null, trim, string, numeric, email, boolean, integer, float, max(int|float), min(int|float), val(5,1,hola mundo,hola), file  

        foreach ($rules as $rule) {

            $exist_param = exist_input($rule[0]);
            $value_param = input($rule[0]);
            $rules_param = isset($rule[1]) ? $rule[1] : [];

            $allows_null = in_array("allows_null", $rules_param);
            $is_file = in_array("file", $rules_param);
            
            if( in_array("trim", $rules_param) ){
                $value_param = trim($value_param);
            }

            if ($exist_param || $is_file) {

                foreach ($rules_param as $rule_single) {

                    $test = array('success' => true, 'message' => '');
                    $error = "Error. La regla '" . $rule_single . "' está mal escrita o es inexistente. Verifica en la documentación la sintaxis para validaciones.";

                    if($value_param != null || !$allows_null){

                        if ($rule_single == "string") {

                            $test = self::rule_string($value_param, $rule[0]);

                        }elseif ($rule_single == "numeric") {

                            $test = self::rule_numeric($value_param, $rule[0]);

                        }elseif ($rule_single == "integer") {

                            $test = self::rule_integer($value_param, $rule[0]);

                        }elseif ($rule_single == "float") {

                            $test = self::rule_float($value_param, $rule[0]);

                        }elseif ($rule_single == "boolean") {

                            $test = self::rule_boolean($value_param, $rule[0]);

                        }elseif ($rule_single == "email") {

                            $test = self::rule_email($value_param, $rule[0]);

                        }elseif ($rule_single == "file") {

                            $test = self::rule_file($value_param, $rule[0]);

                        }elseif( substr($rule_single, 0, 4) == "max(" && substr($rule_single, -1) == ")"){

                            $rule_value = substr($rule_single, 4, -1);
                            
                            if(!is_numeric($rule_value)){
                                echo $error; die(); exit;
                            }

                            $test = self::rule_max($value_param, $rule[0], $rule_value);

                        }elseif( substr($rule_single, 0, 4) == "min(" && substr($rule_single, -1) == ")"){

                            $rule_value = trim(substr($rule_single, 4, -1));
                            
                            if(!is_numeric($rule_value)){
                                echo $error; die(); exit;
                            }

                            $test = self::rule_min($value_param, $rule[0], $rule_value);

                        }elseif( substr($rule_single, 0, 4) == "val(" && substr($rule_single, -1) == ")"){

                            $rule_value = trim(substr($rule_single, 4, -1));
                            
                            if($rule_value == ""){
                                echo $error; die(); exit;
                            }

                            $rule_value = explode(',', $rule_value);
                            
                            $test = self::rule_val($value_param, $rule[0], $rule_value);

                        }elseif ($rule_single == "allows_null" || $rule_single == "trim") {

                            $test = $test;

                        }else{
                            echo $error; die(); exit;
                        }

                    }

                    if (!$test['success']) {
                        array_push($errors, $test['message']);
                    }
                }

            } else {
                array_push($errors, 'El campo/valor ' . $rule[0] . ' no existe y es requerido');
            }

        }

        if ($redirect && count($errors) >= 1) {
            set_errors($errors);
            back();
        }

        return $errors;
    }

    private static function rule_string($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;

        return array(
            'success' => (is_string($value)),
            'message' => 'El campo/valor "' . $name . '" debe ser una cadena de texto'
        );
    }

    private static function rule_numeric($value, $name)
    {
        return array(
            'success' => (is_numeric($value)),
            'message' => 'El campo/valor "' . $name . '" debe ser un dato numérico'
        );
    }

    private static function rule_integer($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;

        return array(
            'success' => (is_int($value)),
            'message' => 'El campo/valor "' . $name . '" debe ser un número entero'
        );
    }

    private static function rule_float($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;

        return array(
            'success' => (is_float($value)),
            'message' => 'El campo/valor "' . $name . '" debe ser un número floatante'
        );
    }
    
    private static function rule_boolean($value, $name)
    {
        return array(
            'success' => (is_bool($value)),
            'message' => 'El campo/valor "' . $name . '" debe ser un dato booleano'
        );
    }

    private static function rule_email($value, $name)
    {
        return array(
            'success' => (false !== filter_var($value, FILTER_VALIDATE_EMAIL)),
            'message' => 'El campo/valor "' . $name . '" debe ser un correo electrónico'
        );
    }

    private static function rule_max($value, $name, $rule_value)
    {
        $test = false;

        if( is_numeric($value) ){
            $value = $value * 1;
            $test = ($rule_value >= $value);
            $message = 'El campo/valor "' . $name . '" no debe ser mayor de ' . $rule_value;
        }else{
            $rule_value = (int)$rule_value;
            $test = ( $rule_value >= strlen($value));
            $message = 'El campo/valor "' . $name . '" no debe ser mayor de ' . $rule_value . ' caracter(es)';

        }

        return array(
            'success' => $test,
            'message' => $message
        );
    }

    private static function rule_min($value, $name, $rule_value)
    {
        $test = false;

        if( is_numeric($value) ){
            $value = $value * 1;
            $test = ($rule_value <= $value);
            $message = 'El campo/valor "' . $name . '" no debe ser menor de ' . $rule_value;
        }else{
            $rule_value = (int)$rule_value;
            $test = ( $rule_value <= strlen($value));
            $message = 'El campo/valor "' . $name . '" no debe ser menor de ' . $rule_value . ' caracter(es)';

        }

        return array(
            'success' => $test,
            'message' => $message
        );
    }

    private static function rule_val($value, $name, $rule_value)
    {
        return array(
            'success' => in_array($value, $rule_value),
            'message' => 'El campo/valor "' . $name . '" no está entre los valores esperados'
        );
    }

    private static function rule_file($value, $name)
    {   
        return array(
            'success' => (isset($_FILES[$name]) && $_FILES[$name]['error'] == 0),
            'message' => 'El campo/valor "' . $name . '" debería contener un archivo enviado'
        );
    }

}
