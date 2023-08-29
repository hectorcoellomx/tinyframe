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
        list($header, $payload, $signature) = explode('.', $token);

        $decodedSignature = self::base64UrlDecode($signature);
        $expectedSignature = hash_hmac('sha256', $header . '.' . $payload, self::$secretKey, true);

        if ($decodedSignature !== $expectedSignature) {
            return false;
        }

        $decodedPayload = json_decode(self::base64UrlDecode($payload), true);

        // Verificar si el token ha expirado
        if (isset($decodedPayload['exp']) && $decodedPayload['exp'] < time()) {
            return false;
        }

        return $decodedPayload;
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

// Crear un token

$expiration = 3600; // Expira en una hora
$data = ['user_id' => 123, 'username' => 'john.doe'];
$token = TokenManager::generateToken($data, $expiration);

// Validar un token
$decodedData = TokenManager::validateToken($token);

if ($decodedData !== false) {
    echo "Token válido. Datos decodificados: ";
    print_r($decodedData);
} else {
    echo "Token inválido.";
}

*/