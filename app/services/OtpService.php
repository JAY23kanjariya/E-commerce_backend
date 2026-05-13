<?php

namespace App\services;

class OtpService
{
    public static function generate()
    {
        return str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
    }
}
