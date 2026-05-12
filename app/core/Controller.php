<?php

/*
|--------------------------------------------------------------------------
| Base Controller Class
|--------------------------------------------------------------------------
|
| This class acts as the parent/base controller for the application.
| It contains common helper methods that can be reused by all
| controllers in the project.
|
| Current Feature:
| - Send JSON responses for APIs
|
| Purpose of json() Method:
| - Set HTTP response status code
| - Set response type as JSON
| - Convert PHP array/object into JSON format
| - Send API response to client/frontend
|
| Why This Is Useful:
| - Keeps API response handling centralized
| - Avoids repeating JSON response code in every controller
| - Makes controllers cleaner and more maintainable
|
| Example Usage:
|
| return $this->json([
|     'success' => true,
|     'message' => 'User created successfully'
| ]);
|
| Example Output:
|
| {
|     "success": true,
|     "message": "User created successfully"
| }
|
| Example with Custom Status Code:
|
| return $this->json([
|     'error' => 'Validation Failed'
| ], 422);
|
*/

namespace App\core;

class Controller
{

    public function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
