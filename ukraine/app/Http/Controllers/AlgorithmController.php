<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

class AlgorithmController extends Controller
{

    public function index()
    {
        return view('home');
    }
}
