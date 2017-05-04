<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use App\Object;

use App\PrototypeFields;

use App\Http\Controllers\Controller;



class ObjectController extends Controller
{

    public function index()
    {

        $objects = Object::with("prototypes.fields")->get();

        $fields = PrototypeFields::all();

        return response()->json(["objects" => $objects]);
    }
}
