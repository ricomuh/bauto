<?php

namespace App\Controllers;

use Engine\Handler\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function intro($name)
    {
        return json([
            'name' => $name
        ]);
    }
}
