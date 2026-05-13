<?php

namespace App\middlewares;

use App\services\JWTService;
use App\core\Response;

class AuthMiddleware
{
    public static function handle()
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            Response::json([
                'success' => false,
                'message' => 'Access denied'
            ], 401);
        }

        $authHeader = $headers['Authorization'];

        $token = str_replace('Bearer ', '', $authHeader);

        $decoded = JWTService::verify($token);

        if (!$decoded) {
            Response::json([
                'success' => false,
                'message' => 'Access denied'
            ], 401);

            exit;
        }

        return $decoded;
    }
}
