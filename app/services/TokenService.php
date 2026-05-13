<?php

namespace App\services;

class TokenService
{
    public static function generate($length = 64)
    {
        return bin2hex(random_bytes($length / 2));
    }
}
