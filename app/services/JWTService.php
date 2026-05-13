<?php

namespace App\services;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTService
{
    public static function generate($data)
    {
        $payload = [
            'id' => $data['id'],
            'email' => $data['email'],
            'iat' => time(),
            'exp' => time() + $_ENV['JWT_EXPIRE']
        ];

        return JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
    }

    public static function verify($token)
    {
        try {
            return JWT::decode($token, new key($_ENV['JWT_SECRET'], 'HS256'));
        } catch (Exception $e) {
            return false;
        }
    }
}
