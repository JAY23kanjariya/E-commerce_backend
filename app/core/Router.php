<?php

/*
|--------------------------------------------------------------------------
| Router Class
|--------------------------------------------------------------------------
|
| This class is responsible for handling application routing.
| It maps URLs (routes) to specific callback functions and
| executes the correct callback based on the incoming request.
|
| Purpose:
| - Register application routes
| - Handle GET and POST requests
| - Match requested URL with defined routes
| - Execute corresponding controller/function
| - Return 404 response if route does not exist
|
| How Routing Works:
|
| 1. User sends request:
|    Example:
|    GET /users
|
| 2. Router checks:
|    - Request Method (GET/POST)
|    - Request URI (/users)
|
| 3. If route exists:
|    -> Executes assigned callback function
|
| 4. If route does not exist:
|    -> Returns 404 "Route Not Found"
|
| Route Storage Structure:
|
| $routes = [
|     'GET' => [
|         '/users' => callback
|     ],
|     'POST' => [
|         '/login' => callback
|     ]
| ];
|
| Methods:
|
| get($uri, $callback)
| -> Register GET routes
|
| post($uri, $callback)
| -> Register POST routes
|
| resolve()
| -> Match current request and execute callback
|
| Important PHP Functions Used:
|
| parse_url()
| -> Extracts URL path
|
| call_user_func()
| -> Dynamically executes callback function
|
| $_SERVER['REQUEST_METHOD']
| -> Returns HTTP request method
|
| $_SERVER['REQUEST_URI']
| -> Returns current request URL
|
| Example Usage:
|
| $router->get('/users', function () {
|     echo "Users Page";
| });
|
| $router->post('/login', function () {
|     echo "Login API";
| });
|
| $router->resolve();
|
*/

namespace App\core;

class Router
{
    private array $routes = [];

    public function get($uri, $callback)
    {
        $this->routes['GET'][$uri] = $callback;
    }

    public function post($uri, $callback)
    {
        $this->routes['POST'][$uri] = $callback;
    }

    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        $callback = $this->routes[$method][$uri] ?? false;

        if (!$callback) {
            http_response_code(404);
            echo json_encode([
                "message" => "Route Not Found"
            ]);
            return;
        }

        call_user_func($callback);
    }
}
