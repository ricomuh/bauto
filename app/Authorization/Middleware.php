<?php

namespace App\Authorization;

use Engine\Authorization\Middleware as MiddlewareKernel;

class Middleware extends MiddlewareKernel
{
    protected $middleware = [
        'auth' => 'auth',
        'guest' => 'guest',
    ];

    public function auth()
    {

        if (!isset($_SESSION['user'])) {
            if (request()->acceptJSON()) return abort(401, 'Unauthorized');
            return redirect('/login');
        }

        return true;
    }

    public function guest()
    {
        if (isset($_SESSION['user'])) {
            if (request()->acceptJSON()) return abort(403, 'Forbidden');
            return redirect('/');
        }

        return true;
    }
}
