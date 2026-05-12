<?php

/*
|--------------------------------------------------------------------------
| Response Handler Class
|--------------------------------------------------------------------------
|
| This class is responsible for sending HTTP responses from the
| application to the client/browser in JSON format.
|
| Purpose:
| - Standardize API responses
| - Send structured JSON data
| - Set proper HTTP status codes
| - Reduce repeated response code across the project
|
| Why Use This Class?
| - Keeps controllers clean and simple
| - Makes API response handling reusable
| - Ensures consistent response format
|
| Features:
| - Static json() method
| - Supports custom HTTP status codes
| - Automatically sets JSON response headers
| - Converts PHP arrays/objects into JSON format
|
| Parameters:
|
| $data
| -> The response data to send
| -> Can be array or object
|
| $status
| -> HTTP response status code
| -> Default is 200 (OK)
|
| Common Status Codes:
|
| 200 -> Success
| 201 -> Resource Created
| 400 -> Bad Request
| 401 -> Unauthorized
| 404 -> Not Found
| 422 -> Validation Error
| 500 -> Internal Server Error
|
| Example Usage:
|
| Response::json([
|     'success' => true,
|     'message' => 'User fetched successfully'
| ]);
|
| Example Output:
|
| {
|     "success": true,
|     "message": "User fetched successfully"
| }
|
| Example with Custom Status:
|
| Response::json([
|     'error' => 'User not found'
| ], 404);
|
*/

namespace App\core;

class Response
{

    public static function json($data, $status = 200)
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
