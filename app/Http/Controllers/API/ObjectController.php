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

      $objects = Object::with("_prototypes.parameters.properties")->active()->get();
      //return $objects->toJson();

      return response()->json(["objects" => $objects], 200, [], JSON_PRETTY_PRINT);
    }
}
