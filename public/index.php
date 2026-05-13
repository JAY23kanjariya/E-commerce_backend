<?php

date_default_timezone_set('Asia/Kolkata');

require_once __DIR__ . '/../vendor/autoload.php';

use App\core\Env;
use App\core\Database;
use App\core\Router;


Env::load(__DIR__ . '/../.env');

Database::connect();

$router = new Router();
require_once __DIR__ . '/../routes/api.php';

$router->resolve();
