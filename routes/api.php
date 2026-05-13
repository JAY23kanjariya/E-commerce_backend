<?php

use App\core\Response;
use App\controllers\AuthController;
use App\middlewares\AuthMiddleware;

$authController = new AuthController();

$router->get('/', function () {
    Response::json([
        "message" => "Ecommerce Backend Running & Database Connected Successfully"
    ]);
});

$router->post('/register', function () use ($authController) {
    $authController->register();
});

$router->post('/login', function () use ($authController) {
    $authController->login();
});

$router->post('/verify-otp', function () use ($authController) {
    $authController->verifyOtp();
});

$router->post('/forgotPassword', function () use ($authController) {
    $authController->forgotPassword();
});

$router->get('/profile',function () {
    $user =  AuthMiddleware::handle();

    Response::json([
        'success' => true,
        'message' => 'Protected route accessed',
        'user' => $user
    ]);
});
