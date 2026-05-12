<?php

/*
|--------------------------------------------------------------------------
| Environment File Loader
|--------------------------------------------------------------------------
|
| This class is used to load environment variables from a .env file
| and store them inside PHP's global $_ENV array.
|
| Purpose:
| - Keep sensitive data outside the main codebase
| - Manage configuration values easily
| - Access application settings globally
|
| Example .env File:
|
| APP_NAME=MyProject
| DB_HOST=localhost
| DB_USER=root
|
| How It Works:
| 1. Checks whether the .env file exists
| 2. Reads the file line by line
| 3. Ignores empty lines and comments (#)
| 4. Splits each line into KEY=VALUE format
| 5. Stores values inside $_ENV array
|
| Example Result:
|
| $_ENV['APP_NAME'] => MyProject
| $_ENV['DB_HOST']  => localhost
|
| Usage:
|
| Env::load(__DIR__ . '/../.env');
|
*/

namespace App\core;

class Env
{

    public static function load($path)
    {
        if (!file_exists($path)) {
            return false;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            if (str_starts_with(trim($line), '#')) {
                continue;
            }

            list($key, $value) = explode('=', $line, 2);

            $_ENV[trim($key)] = trim($value);
        }
    }
}
