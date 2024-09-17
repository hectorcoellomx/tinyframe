<?php

function redir($path="", $url=false){
    if(!$url){
        global $tinyapp_config;
        header("Location: " . $tinyapp_config->base_url . $path);
        exit();
    }else{
        header("Location: " . $path);
        exit();
    }
    
}

function get_version(){
    global $tinyapp_version;
    return $tinyapp_version;
}

function vd($vars, $stop=true) {
    
    $vars = [
        $vars, ['stopExecution' => $stop]
    ];

    $showTrace=true;
    $stopExecution = true;

    if (is_array(end($vars))) {
        $options = array_pop($vars);
        $stopExecution = $options['stopExecution'] ?? true;
    }

    echo '<pre style="border: 2px dashed gainsboro; background-color: #f8f9fa; color: #212529; padding: 10px; border-radius: 5px; font-family: monospace;">';

    foreach ($vars as $var) {
        ob_start();
        var_dump($var);
        $dumpOutput = ob_get_clean();

        // Apply syntax highlighting
        $dumpOutput = htmlspecialchars($dumpOutput);
        $dumpOutput = preg_replace([
            '/"(.*?)"/',                    // Strings
            '/\b(int|float|bool|string)\((.*?)\)/',  // Data types
            '/\b(array)\((\d+)\)/',         // Arrays
            '/\b(object)\((.*?)\)#(\d+) \((\d+)\)/', // Objects
            '/\b(resource)\((\d+)\) of type \((.*?)\)/', // Resources
            '/\bNULL\b/',                   // NULL values
        ], [
            '<span style="color: #28a745;">"$1"</span>',  // Green for strings
            '<span style="color: #007bff;">$1</span>(<span style="color: #dc3545;">$2</span>)',  // Blue for type, red for value
            '<span style="color: #35a615;">$1</span>(<span style="color: #dc3545;">$2</span>)',  // Arrays
            '<span style="color: #6610f2;">$1</span>(<span style="color: #e83e8c;">$2</span>)#<span style="color: #fd7e14;">$3</span> (<span style="color: #6f42c1;">$4</span>)',  // Objects
            '<span style="color: #20c997;">$1</span>(<span style="color: #dc3545;">$2</span>) of type (<span style="color: #ffc107;">$3</span>)',  // Resources
            '<span style="color: #6c757d;">NULL</span>',  // Gray for NULL
        ], $dumpOutput);

        echo $dumpOutput . "\n";
    }

    if ($showTrace) {
        echo "\n<strong>Backtrace:</strong>\n";
        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        foreach ($trace as $index => $call) {
            echo "#{$index} {$call['file']}({$call['line']}): {$call['function']}()\n";
        }
    }

    echo '</pre>';

    if ($stopExecution) {
        exit;
    }
}


function back(){
    return redir($_SERVER['HTTP_REFERER'], true);
}

function set_errors($errors){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['validator_errors'] = $errors;
}

function get_errors(){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $errors = array();
    if(isset($_SESSION['validator_errors'])){
        $errors = $_SESSION['validator_errors'];
        unset($_SESSION['validator_errors']);
    }
    return  $errors;
}

function base($add=""){
    global $tinyapp_config;
    return $tinyapp_config->base_url . $add;
}

function assets($add=""){
    global $tinyapp_config;
    echo $tinyapp_config->base_url . 'assets/'. $add;
}

function input_json(){
    $data = file_get_contents("php://input");
    return json_decode($data, true);
}

function input($name, $type="all"){

    $value= NULL;
    
    if ( $type=="post" || $type=="put" || $type=="delete" || $type=="all" ) {
        $value = isset($_POST[$name]) ? $_POST[$name] : NULL;
        
        if($value==NULL){
            
            $data = file_get_contents("php://input");
            $data_decode = json_decode($data, true);

            if($data_decode==NULL){
                parse_str(file_get_contents("php://input"), $data_decode);
            }

            $value = isset($data_decode[$name]) ? $data_decode[$name] : NULL;
        }
    }

    if( $type=="get" || ($type=="all" && $value==NULL) ){
        $value = isset($_GET[$name]) ? $_GET[$name] : NULL;
    }

    if( $type=="url"  || ($type=="all" && $value==NULL) ){
        global $tinyapp_url_response;
        $value = isset( $tinyapp_url_response[$name] ) ? $tinyapp_url_response[$name] : NULL;
    }

    if( $type=="headers" || ($type=="all" && $value==NULL) ){
        $value = isset( getallheaders()[$name] ) ? getallheaders()[$name] : NULL;
    }
    
    return $value;
}

function exist_input($name){
    $value= false;
    
    if ( isset($_POST[$name]) || isset($_GET[$name]) ) {
        $value = true;
    }else{

        $data = file_get_contents("php://input");
        $data_decode = json_decode($data, true);

        if($data_decode==NULL){
            parse_str(file_get_contents("php://input"), $data_decode);
        }
        
        $value = isset($data_decode[$name]);

        if(!$value){
            global $tinyapp_url_response;
            if( isset( $tinyapp_url_response[$name] ) ){
                $value = true;
            }
        }

        if(!$value){
            $value = isset( getallheaders()[$name] );
        }
        
    }
    
    return $value;
}


