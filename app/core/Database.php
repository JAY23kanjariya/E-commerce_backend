<?php

/*
|--------------------------------------------------------------------------
| Database Connection Manager
|--------------------------------------------------------------------------
|
| This class is responsible for creating and managing a single
| database connection using PHP PDO (PHP Data Objects).
|
| Purpose:
| - Connect the application with MySQL database
| - Use environment variables for secure configuration
| - Prevent multiple unnecessary database connections
| - Provide a reusable database connection throughout the project
|
| Environment Variables Used:
|
| DB_HOST = Database server host
| DB_PORT = Database server port
| DB_NAME = Database name
| DB_USER = Database username
| DB_PASS = Database password
|
| How It Works:
| 1. Checks if a database connection already exists
| 2. If not, creates a new PDO connection
| 3. Stores the connection in a static variable
| 4. Returns the same connection whenever needed
|
| Why Static Connection?
| - Improves performance
| - Reduces memory usage
| - Avoids reconnecting to database repeatedly
|
| PDO Features Used:
| - Secure database connection
| - Exception-based error handling
| - Database abstraction support
|
| Example Usage:
|
| $db = Database::connect();
|
*/

namespace App\core;

use PDO;
use PDOException;

class Database
{

    private static $connection = null;

    public static function connect()
    {

        if (self::$connection === null) {
            $host = $_ENV['DB_HOST'];
            $port = $_ENV['DB_PORT'];
            $dbname = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASS'];

            try {
                self::$connection = new PDO(
                    "mysql:host=$host;port=$port;dbname=$dbname",
                    $user,
                    $pass
                );

                self::$connection->setAttribute(
                    PDO::ATTR_ERRMODE,
                    PDO::ERRMODE_EXCEPTION
                );
            } catch (PDOException $error) {

                die("ERROR : Database Connection Failed " . $error->getMessage());
            }
        }

        return self::$connection;
    }
}
