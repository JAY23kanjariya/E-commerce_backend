<?php

/*
|--------------------------------------------------------------------------
| Request Handler Class
|--------------------------------------------------------------------------
|
| This class is responsible for handling incoming HTTP request data
| from the client/frontend application.
|
| Purpose:
| - Read raw request body data
| - Convert JSON request data into PHP array format
| - Provide easy access to API request payloads
|
| Why This Class Is Useful:
| - Centralizes request handling
| - Simplifies API data processing
| - Avoids repeating request parsing code
| - Makes controllers cleaner and easier to maintain
|
| How It Works:
|
| 1. file_get_contents("php://input")
|    -> Reads raw request body data sent by the client
|
| 2. json_decode(..., true)
|    -> Converts JSON string into associative PHP array
|
| Example Incoming JSON Request:
|
| {
|     "name": "Jay",
|     "email": "jay@example.com"
| }
|
| Example Returned PHP Array:
|
| [
|     "name" => "Jay",
|     "email" => "jay@example.com"
| ]
|
| Example Usage:
|
| $data = Request::body();
|
| echo $data['name'];
|
| Commonly Used In:
| - REST APIs
| - Login/Register APIs
| - Form submission handling
| - Frontend to backend communication
|
*/

namespace App\core;

class Request
{
    public static function body()
    {
        return json_decode(file_get_contents("php://input"), true);
    }
}
