<?php

namespace Core;

class Validator
{

    function check($rules, $redirect = true)
    {

        $errors = array();

        // allows_null, trim, string, numeric, email, boolean, integer, float, max(int|float), min(int|float), val(5,1,hola mundo,hola), file  

        foreach ($rules as $rule) {

            $req = new \Core\Request();

            $exist_param = $req->exist_input($rule[0]);
            $value_param = $req->input($rule[0]);
            $rules_param = isset($rule[1]) ? $rule[1] : [];

            $allows_null = in_array("allows_null", $rules_param);
            $is_file = in_array("file", $rules_param);
            
            if( in_array("trim", $rules_param) ){
                $value_param = trim($value_param);
            }

            if ($exist_param || $is_file) {

                foreach ($rules_param as $rule_single) {

                    $test = array('success' => true, 'message' => '');
                
                    if (!empty($value_param) || $value_param === "0" || $value_param === 0 || !$allows_null){

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
                                throw new \Exception("Regla inválida: " . $rule_single);
                            }

                            $test = self::rule_max($value_param, $rule[0], $rule_value);

                        }elseif( substr($rule_single, 0, 4) == "min(" && substr($rule_single, -1) == ")"){

                            $rule_value = trim(substr($rule_single, 4, -1));
                            
                            if(!is_numeric($rule_value)){
                                throw new \Exception("Regla inválida: " . $rule_single);
                            }

                            $test = self::rule_min($value_param, $rule[0], $rule_value);

                        }elseif( substr($rule_single, 0, 4) == "val(" && substr($rule_single, -1) == ")"){

                            $rule_value = trim(substr($rule_single, 4, -1));
                            
                            if($rule_value == ""){
                                throw new \Exception("Regla inválida: " . $rule_single);
                            }

                            $rule_value = explode(',', $rule_value);
                            
                            $test = self::rule_val($value_param, $rule[0], $rule_value);

                        }elseif ($rule_single == "allows_null" || $rule_single == "trim") {

                            $test = $test;

                        }else{
                            throw new \Exception("Regla inválida: " . $rule_single);
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

    private static function result($condition, $message)
    {
        return [ 'success' => $condition, 'message' => $message ];
    }


    private static function rule_string($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;
        return self::result((is_string($value)), "El campo $name debe ser cadena de texto"); 
    }

    private static function rule_numeric($value, $name)
    {
        return self::result((is_numeric($value)), "El campo $name debe ser numérico");
    }

    private static function rule_integer($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;
        return self::result((is_int($value)), "El campo $name debe ser número entero");
    }

    private static function rule_float($value, $name)
    {
        $value = (is_numeric($value)) ? $value * 1 : $value;
        return self::result(is_float($value), "El campo $name debe ser número floatante"); 
    }
    
    private static function rule_boolean($value, $name)
    {
        return self::result( (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null), "El campo $name debe ser booleano");
    }

    private static function rule_email($value, $name)
    {
        return self::result( (false !== filter_var($value, FILTER_VALIDATE_EMAIL)), "El campo $name debe ser un correo electrónico"); 
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
        return self::result($test, $message);
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

        return self::result($test, $message);
    }

    private static function rule_val($value, $name, $rule_value)
    {
        return self::result(in_array($value, $rule_value), 'El campo "' . $name . '" no está entre los valores esperados');
    }

    private static function rule_file($value, $name)
    {   
        return self::result((isset($_FILES[$name]) && $_FILES[$name]['error'] == 0), 'El campo "' . $name . '" debería contener un archivo enviado');
    }

}
