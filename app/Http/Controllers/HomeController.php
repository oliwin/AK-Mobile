<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Redirect;

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
