<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{

    public function index()
    {
        
        if (Auth::check()) {
            return Redirect::to('/objects');
        }

        return view('home');
    }
}
