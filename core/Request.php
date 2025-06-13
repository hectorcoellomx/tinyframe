<?php 

namespace Core;

class Request {

    protected $data;
    protected $headers;

    public function __construct() {
        $this->data = $this->parseInput();
        //$this->headers = getallheaders();
    }

    protected function parseInput() {
        $input = $_POST + $_GET;
        $raw = file_get_contents("php://input");
        $decoded = json_decode($raw, true);

        if (is_array($decoded)) {
            $input = array_merge($input, $decoded);
        }

        return $input;
    }

    public function input($key, $default = null) {
        return $this->data[$key] ?? $default;
    }

    function exist_input($key){
        return (isset($this->data[$key]));
    }

    public function header($key, $default = null) {
        return $this->headers[$key] ?? $default;
    }

    public function all($type="input") {
        return ($type=="input") ? $this->data : ( ($type=="header") ? $this->headers : null );
    }

    function validate($rules){
        $validator = new \Core\Validator(); 
        $validator->check($rules);
    }

}
