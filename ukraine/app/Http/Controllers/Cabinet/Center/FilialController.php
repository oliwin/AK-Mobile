<?php

namespace App\Http\Controllers\Cabinet\Center;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\URL;

use App\User;

class FilialController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filials = User::all();

        return view('cabinet.center.filials.index', ["filials" => $filials]);
    }
}
