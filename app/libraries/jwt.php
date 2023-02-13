<?php

require_once 'vendor/autoload.php';
use \Firebase\JWT\JWT;

// Clave secreta utilizada para codificar y decodificar el token JWT
$secret_key = "miClaveSecreta";

// Datos a incluir en el token JWT
$payload = array(
    "iss" => "http://miSitioWeb.com",
    "iat" => time(),
    "exp" => time() + 3600,
    "data" => array(
        "id_usuario" => 12345,
        "nombre_usuario" => "miNombreDeUsuario"
    )
);

// Codifica los datos en el token JWT
$jwt = JWT::encode($payload, $secret_key);

// Decodificamos el token JWT
try {
    $decoded = JWT::decode($jwt, $secretKey, ['HS256']);
    print_r($decoded);
} catch (Exception $e) {
    echo "Token inválido";
}



///////////////////////////////////////////////



// Clave secreta para firmar el token
$secretKey = "miClaveSecreta";

// Datos para codificar en el token
$data = [
    "subject" => "usuario123",
    "issuedAt" => time(),
    "expiresAt" => time() + 3600
];

// Codificamos los datos en el token JWT
$header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
$payload = json_encode($data);
$hmac = hash_hmac('sha256', $header . "." . $payload, $secretKey, true);
$jwt = base64_encode($header) . "." . base64_encode($payload) . "." . base64_encode($hmac);

// Decodificamos el token JWT
list($header64, $payload64, $signature64) = explode('.', $jwt);
$header = json_decode(base64_decode($header64), true);
$payload = json_decode(base64_decode($payload64), true);
$signature = base64_decode($signature64);
$expectedSignature = hash_hmac('sha256', $header64 . "." . $payload64, $secretKey, true);

if ($signature !== $expectedSignature) {
    echo "Token inválido";
} else {
    print_r($payload);
}