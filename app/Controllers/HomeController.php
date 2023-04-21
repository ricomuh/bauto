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
        ];

        return json($data, 200);
    }

    public function test2($id = null)
    {
        echo 'This is get method with id: ';
        echo $id;
    }
}
