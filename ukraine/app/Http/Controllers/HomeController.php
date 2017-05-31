<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use App\User;

use App\Client;

use App\Http\Requests;



class HomeController extends Controller
{

    public function index()
    {
        return view('home');
    }

    public function counter(){


        $conclusions = Client::where("status", 3)->get()->count();

        return response()->json(["conclusions" => $conclusions]);

    }
}
