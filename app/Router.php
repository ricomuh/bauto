<?php

namespace App;

use Engine\Router\RouterKernel;
use Engine\Router\Route;

use App\Controllers\HomeController;

class Router extends RouterKernel
{
    public function application(Route $route)
    {
        $route->get('/', HomeController::class, 'index')->name('home');
        $route->get('/test', HomeController::class, 'test')->name('test');
        $route->get('/test2/{id}', HomeController::class, 'test2')->name('test2');
    }
}
