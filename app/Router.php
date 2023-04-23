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
        $route->get('/error', HomeController::class, 'error')->name('error');
        $route->get('/test', HomeController::class, 'test')->name('test');
        $route->get('/test2', HomeController::class, 'test2')->name('test2');
        $route->get('/test3/:id/test', HomeController::class, 'test3')->name('test3');
        $route->get('/test_redirect', HomeController::class, 'test_redirect')->name('test_redirect');
    }
}
