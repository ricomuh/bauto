<?php

namespace App;

use Engine\Router\RouterKernel;
use Engine\Router\Route;

use App\Controllers\HomeController;

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
