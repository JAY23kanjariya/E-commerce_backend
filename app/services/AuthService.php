<?php

namespace App\services;

use App\models\User;

class AuthService
{
    public static function register($data)
    {
        $userModel = new User();

        $existingUser = $userModel->findBy('email', $data['email']);

        if ($existingUser) {
            return [
                'success' => false,
                'message' => 'Email already Exists'
            ];
        }

        $otp = OtpService::generate();

        $userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'otp' => $otp,
            'otp_expires_at' => date('Y-m-d H:i:s', strtotime('+10 minutes'))
        ]);

        return [
            'success' => true,
            'message' => 'User registerd successfully',
            'otp' => $otp
        ];
    }

    public static function login($data)
    {
        $userModel = new User();

        // check users's email 
        $existingUser = $userModel->findBy('email', $data['email']);

        if (!$existingUser) {
            return [
                'success' => false,
                'message' => 'Invalid Email or Password'
            ];
        }

        if (!password_verify($data['password'], $existingUser['password'])) {

            return [
                'success' => false,
                'message' => 'Invalid Email or Password'
            ];
        }

        // check user's is verified
        if (!$existingUser['is_verified']) {
            return [
                'success' => false,
                'message' => 'Please Verify your account first'
            ];
        }

        $token = JWTService::generate($existingUser);

        return [
            'success' => true,
            'message' => 'User Login Successfully',
            'token' => $token,
            'user' => [
                'id' => $existingUser['id'],
                'name' => $existingUser['name'],
                'email' => $existingUser['email']
            ]
        ];
    }

    public static function verifyOtp($data)
    {
        $userModel = new User();

        $existingUser = $userModel->findBy('email', $data['email']);

        if (!$existingUser) {
            return [
                'success' => false,
                'message' => 'User not Found'
            ];
        }

        if ($existingUser['is_verified']) {
            return [
                'success' => false,
                'message' => 'Account is already verified'
            ];
        }

        if ($data['otp'] !== $existingUser['otp']) {
            return [
                'success' => false,
                'message' => 'Invalid OTP'
            ];
        }

        if (strtotime($existingUser['otp_expires_at']) < time()) {
            return [
                'success' => false,
                'message' => 'OTP expired'
            ];
        }

        $userModel->updateBy('email', $data['email'], [
            'is_verified' => true,
            'otp' => null,
            'otp_expires_at' => null
        ]);

        return [
            'success' => true,
            'message' => 'Account verified Successfully'
        ];
    }

    public static function forgotpassword($data)
    {
        $userModel = new User();

        $existingUser = $userModel->findBy('email', $data['email']);

        if (!$existingUser) {
            return [
                'success' => false,
                'message' => 'User not Found'
            ];
        }

        $token = TokenService::generate();

        $expire_at = date('Y-m-d H:m:s', strtotime('+15 minutes'));

        $userModel->updateBy('email', $data['email'], [
            'reset_password_token' => $token,
            'reset_password_expires_at' => $expire_at
        ]);

        return [
            'success' => true,
            'message' => 'Password reset token generated',
            'reset_token' => $token,
            'expires_at' => $expire_at
        ];
    }
}
