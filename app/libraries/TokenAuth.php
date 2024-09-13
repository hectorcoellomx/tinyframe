<?php 

namespace App\Libraries;

class TokenAuth {

    private static $secretKey = 'your_secret_key_here';

    public static function generateToken($data, $expiration = null)
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        
        if ($expiration !== null) {
            $data['exp'] = time() + $expiration;
        }
        
        $payload = json_encode($data);
        
        $base64Header = self::base64UrlEncode($header);
        $base64Payload = self::base64UrlEncode($payload);
        
        $signature = hash_hmac('sha256', $base64Header . '.' . $base64Payload, self::$secretKey, true);
        $base64Signature = self::base64UrlEncode($signature);
        
        return $base64Header . '.' . $base64Payload . '.' . $base64Signature;
    }

    public static function validateToken($token)
    {
        $token_divide = (is_string($token)) ? explode('.', $token) : array();
        
        if(count($token_divide)!=3){
            return [ "status" => false, "payload" => null, "message" => "Wrong token" ];
        }

        list($header, $payload, $signature) = $token_divide;

        $decodedSignature = self::base64UrlDecode($signature);
        $expectedSignature = hash_hmac('sha256', $header . '.' . $payload, self::$secretKey, true);

        if ($decodedSignature !== $expectedSignature) {
            return [ "status" => false, "payload" => null, "message" => "Invalid token" ];
        }

        $decodedPayload = json_decode(self::base64UrlDecode($payload), true);

        if (isset($decodedPayload['exp']) && $decodedPayload['exp'] < time()) {
            return [ "status" => false, "payload" => null, "message" => "Expired token" ];
        }

        return [ "status" => true, "payload" => $decodedPayload, "message" => "" ];
    }

    private static function base64UrlEncode($data)
    {
        $base64 = base64_encode($data);
        return str_replace(['+', '/', '='], ['-', '_', ''], $base64);
    }

    private static function base64UrlDecode($base64)
    {
        $base64 = str_replace(['-', '_'], ['+', '/'], $base64);
        $padded = $base64 . substr('==', (2 - strlen($base64)  % 3) % 3);
        return base64_decode($padded);
    }

}


/*

require_once './app/libraries/TokenAuth.php';
use App\Libraries\TokenAuth;

// Crear un token

$expiration = 3600; // Expira en una hora
$payload = [
    'iss' => 'http://example.org',
    'aud' => 'http://example.com',
    'iat' => 1356999524,
    'nbf' => 1357000000
];
$token = TokenAuth::generateToken($payload, $expiration);

// Validar un token
$validate = TokenAuth::validateToken($token);

if ($validate["status"]===true) {
    echo "Token válido.";
    echo "Datos decodificados: ";
    print_r($validate["payload"]);
} else {
    echo $validate["message"];
}

*/