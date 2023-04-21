<?php

require_once __DIR__ . '/../engine/bootstrap.php';

use Dotenv\Dotenv;
use App\Router;

$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

$router = new Router();
$router->handle();



// var_dump($_GET);
