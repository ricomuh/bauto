<?php

namespace App\Controllers;

use App\Database\Models\Post;
use Engine\Database\DB;
use Engine\Handler\Controller;

class DatabaseController extends Controller
{

    public function index()
    {
        $posts = Post::all();

        return json($posts);
    }

    public function read($slug)
    {
        $data = Post::find($slug);

        return json($data);
    }
}
