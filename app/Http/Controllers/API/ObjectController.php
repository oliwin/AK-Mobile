<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use App\Object;

use App\PrototypeFields;

use App\Http\Controllers\Controller;

use App\Http\Controllers\API\ObjectTransformer;

use App\Http\Controllers\API\MyTransformer;

use App\Http\Controllers\API\FieldTransformer;

use App\Http\Controllers\API\PrototypeTransformer;

use League\Fractal;

use \League\Fractal\Manager;

use \League\Fractal\Resource\Collection as FractalCollection;

use App\Prototype;

use App\ObjectPrototypeFields;



class ObjectController extends Controller
{

  private $fractal;

  private $object_new;

  public function __construct(){

    $this->fractal = new Manager();
  }

    public function index()
    {

      $prototypes = Prototype::with("name")->get();

      $output = [];
      $prototypes_global = [];
      $objects_global = [];
      $objects_fields = [];

      // Get all prototypes
      foreach ($prototypes as $key => $value) {
         $prototypes_global["id"][$value->prototype_id] = $value->prototype_id;
         $prototypes_global["name"][$value->prototype_id] = $value->name->name;
      }

      // Get all objects based on prototypes
      $objects_fields = ObjectPrototypeFields::with("name")->whereIn("prototype_id", $prototypes_global["id"])->get();

      // Get all objects name
      foreach($objects_fields as $k => $v){
         $objects_fields[$v->object_id][] = $v->value; // de;ete []
         $objects_global[$v->prototype_id][] = $v->name->prefix; // delete []
      }


      ////////////
      //foreach($prototypes_global["id"] as $k => $v){
        //$output[$prototypes_global["name"][$k]] = $objects_global[$k];
      //}

      dd($output);

      $output = [
        "prototype_prefix" => [
           0 => ["object_prefix" => $objects_fields]
        ]
      ];


      //dd($prototypes_global);

      //$transformer = new ObjectTransformer($objects);
      //$transformer->output();

      //$objects = $objects->load("prototypez.properties.name");

      //foreach($objects as $k => $v){
        //  $this->iteratePrototype($v);
      //}

      //dd($this->object_new);

        /*$resource = new Fractal\Resource\Collection($objects, function(Object $obj) {
        $prototypes = new Fractal\Resource\Collection($obj->prototypez()->get(), new PrototypeTransformer);
        $prototypes = $this->fractal ->createData($prototypes);

          return [
              'id'    => (int) $obj->id,
              'title' => $obj->prefix,
              'prototypes' => $prototypes
            ];

        });

        echo $this->fractal ->createData($resource)->toJson();

      //$objects = (new ObjectTransformer)->transform($objects);

      //return response()->json($resource);

      //return response()->json(["objects" => $objects], 200, [], JSON_PRETTY_PRINT);*/
    }
}
