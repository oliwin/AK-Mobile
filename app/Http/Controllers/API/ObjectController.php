<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use App\Object;

use App\PrototypeFields;

use App\Http\Controllers\Controller;

use League\Fractal\Manager;

use League\Fractal\Resource\Collection;

use App\Http\Controllers\API\ObjectTransformer;



class ObjectController extends Controller
{

    public function index()
    {

      $objects = Object::with("_prototypes.properties.name")->active()->get();

      // $prototype_name = $objects->first()->_prototypes->name()->get()->first()->name;

      //return $objects->toJson();

      $books = fractal($objects, new ObjectTransformer())->toArray();

return response()->json($books);

      return response()->json(["objects" => $objects], 200, [], JSON_PRETTY_PRINT);
    }
}
