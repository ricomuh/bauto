<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;
use App\Router;
use Engine\Database\Database;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$db = new Database(
    env('DB_HOST'),
    env('DB_NAME'),
    env('DB_USERNAME'),
    env('DB_PASSWORD')
);

$router = new Router();
$router->handle();
