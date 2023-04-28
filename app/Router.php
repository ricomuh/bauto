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
        // $route->get('/', HomeController::class, 'index')->name('home');
        // $route->get('/error', HomeController::class, 'error')->name('error');
        // $route->get('/test', HomeController::class, 'test')->name('test');
        // $route->get('/test2', HomeController::class, 'test2')->name('test2');
        // $route->get('/test3/:id/test', HomeController::class, 'test3')->name('test3');
        // $route->get('/test_redirect', HomeController::class, 'test_redirect')->name('test_redirect');

        // $route->get('/test4', HomeController::class, 'test4')->name('test4');
        $route->get('/', DatabaseController::class, 'index')->name('index');
        $route->get('/read/:slug', DatabaseController::class, 'read2')->name('read');

        $route->get('/crud/post', PostController::class, 'index')->name('crud.post.index');
        $route->get('/crud/post/create', PostController::class, 'create')->name('crud.post.create');
        $route->post('/crud/post/store', PostController::class, 'store')->name('crud.post.store');
        $route->get('/crud/post/:slug', PostController::class, 'show')->name('crud.post.show');
        $route->get('/crud/post/:slug/edit', PostController::class, 'edit')->name('crud.post.edit');
        $route->post('/crud/post/:slug/update', PostController::class, 'update')->name('crud.post.update');
        $route->post('/crud/post/:slug/destroy', PostController::class, 'destroy')->name('crud.post.destroy');
    }
}
