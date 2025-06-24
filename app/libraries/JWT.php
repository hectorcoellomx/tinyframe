<?php 

namespace App\Libraries;

class JWT {

    private static $secretKey = 'your_secret_key_here';

    public static function setSecretKey($key)
    {
        self::$secretKey = $key;
    }

    public static function generateToken($data, $expiration_minutes = 5)
    {
        $header = json_encode(['alg' => 'HS256', 'typ' => 'JWT']);
        
        if ($expiration_minutes !== null) {
            if (is_numeric($expiration_minutes) && $expiration_minutes >= 0) {
                $data['exp'] = time() + ($expiration_minutes * 60); 
            }
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

        if (!hash_equals($expectedSignature, $decodedSignature)) {
            return [ "status" => false, "payload" => null, "message" => "Invalid token" ];
        }

        $decodedHeader = json_decode(self::base64UrlDecode($header), true);
        if ($decodedHeader['alg'] !== 'HS256') {
            return [ "status" => false, "payload" => null, "message" => "Unsupported algorithm" ];
        }

        $decodedPayload = json_decode(self::base64UrlDecode($payload), true);

        if (!is_array($decodedPayload)) {
            return [ "status" => false, "payload" => null, "message" => "Invalid payload" ];
        }

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

