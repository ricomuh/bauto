<?php

namespace App\Controllers;

use Engine\Handler\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $students = collect([
            [
                'name' => 'Rizky',
                'age' => 20
            ],
            [
                'name' => 'Rico',
                'age' => 21
            ],
            [
                'name' => 'Rizal',
                'age' => 22
            ]
        ]);

        $filtered = $students->filter(function ($student) {
            return $student['age'] > 20;
        });

        return view('makan', compact('students', 'filtered'));
    }

    public function test()
    {
        $data = [
            'nama' => 'Rizky',
            'umur' => 20,
            'base_url' => request()->baseURL(),
            'table_name' => (new \App\Database\Models\Student)->getTableName(),
        ];

        return json($data, 200);
    }

    public function error()
    {
        return abort(403);
    }

    public function test2()
    {
        return env('APP_NAME', 'default');
    }

    public function test3($id)
    {
        return json(['message' => 'test3', 'id' => $id]);
    }

    public function  test_redirect()
    {
        return redirect()->route('test');
    }

    public function test4()
    {
        // $data = cache()->remember('test', 60, function () {
        //     return 'test';
        // });
        $data = cache()->get('test');

        return json(['message' => $data]);
    }
}
