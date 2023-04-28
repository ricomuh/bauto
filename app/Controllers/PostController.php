<?php

namespace App\Controllers;

use Engine\Handler\Controller;
use App\Database\Models\Post;
use Engine\Handler\Request;

class PostController extends Controller
{

    public function index(Request $request)
    {
        $posts = Post::all();
        // dd($posts);
        // return json($posts);
        return view('crud/post/index', compact('posts'));
    }

    public function create()
    {
        return view('crud/post/create');
    }

    public function store(Request $request)
    {
        Post::insert([
            'title' => $request->title,
            'slug' => str($request->title)->slug(),
            'content' => $request->content
        ]);

        return redirect()->route('/crud/post');
    }

    public function show(Post $post)
    {
        return view('crud/post/show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('crud/post/edit', compact('post'));
    }

    public function update(Post $post, Request $request)
    {
        dd($request);
        $post->update([
            'title' => $request->title,
            'slug' => str($request->title)->slug(),
            'content' => $request->content
        ]);

        return redirect()->route('/crud/post');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('/crud/post');
    }
}
