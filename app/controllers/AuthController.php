<?php

namespace App\controllers;

use App\core\Controller;
use App\services\AuthService;
use App\Validations\AuthValidation;
use App\Core\Request;

class AuthController extends Controller
{
    public function register()
    {
        $data = Request::body();
        $errors = AuthValidation::register($data);

        if (!empty($errors)) {
            return $this->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $response = AuthService::register($data);

        return $this->json($response);
    }

    public function login()
    {
        $data = Request::body();
        $errors = AuthValidation::login($data);

        if (!empty($errors)) {
            return $this->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $response = AuthService::login($data);

        return $this->json($response);
    }

    public function verifyOtp()
    {
        $data = Request::body();
        $errors = AuthValidation::verifyOtp($data);

        if (!empty($errors)) {
            return $this->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $response = AuthService::verifyOtp($data);

        return $this->json($response);
    }

    public function forgotPassword(){
        $data = Request::body();
        $errors = AuthValidation::forgotpassword($data);

        if (!empty($errors)) {
            return $this->json([
                'success' => false,
                'errors' => $errors
            ], 422);
        }

        $response = AuthService::forgotpassword($data);

        return $this->json($response);
    }
}
