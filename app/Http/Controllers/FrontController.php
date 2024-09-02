<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('front.index', [
            'title' => 'Homepage Art Gallery Udinus'
        ]);
    }

    public function show()
    {
        return view('front.show', [
            'title' => 'Detail Art'
        ]);
    }
}