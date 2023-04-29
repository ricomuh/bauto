<?php

namespace App\Controllers;

use Engine\Handler\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
