<?php

function assets($add=""){
    global $tinyapp_config;
    echo $tinyapp_config->base_url . 'assets/'. $add;
}

function back(){
    return redir($_SERVER['HTTP_REFERER'], true);
}

function base($add=""){
    global $tinyapp_config;
    return $tinyapp_config->base_url . $add;
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

function get_version(){
    global $tinyapp_version;
    return $tinyapp_version;
}

function redir($path, $external=false){
    if(!$external){
        global $tinyapp_config;
        header("Location: " . $tinyapp_config->base_url . $path);
        exit();
    }else{
        header("Location: " . $path);
        exit();
    }
    
}

function set_errors($errors){
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['validator_errors'] = $errors;
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







