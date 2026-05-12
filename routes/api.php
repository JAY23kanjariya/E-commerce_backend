<?php

use App\core\Response;

$router->get('/', function () {
    Response::json([
        "message" => "Ecommerce Backend Running & Database Connected Successfully"
    ]);
});
