<?php

namespace App;

use App\Controllers\DatabaseController;
use Engine\Router\RouterKernel;
use Engine\Router\Route;

use App\Controllers\HomeController;
use App\Controllers\PostController;

class Router extends RouterKernel
{
    /**
     * Application routes
     * 
     * @param Route $route
     * @return void
     */
    public function application(Route $route)
    {
        $route->get('/', HomeController::class, 'index')->name('home');
    }
}
