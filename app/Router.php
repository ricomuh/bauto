<?php

namespace App;

use Engine\Router\RouterKernel;
use Engine\Router\Route;
use App\Authorization\Middleware;

use App\Controllers\HomeController;

class Router extends RouterKernel
{

    /**
     * Application middleware
     * 
     * @var string
     */
    protected $middleware = Middleware::class;

    /**
     * Application routes
     * 
     * @param Route $route
     * @return void
     */
    public function application(Route $route)
    {
        $route->get('/', HomeController::class, 'index')->name('home');
        $route->get('/intro/:name', HomeController::class, 'intro')->name('intro');
        $route->get('/test/middle', HomeController::class, 'test_middle')->name('test.middle')->middleware('auth');
        $route->get('/test/guest', HomeController::class, 'test_guest')->name('test.guest')->middleware('guest');
    }
}
