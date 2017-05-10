<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;

use App\PrototypeName;

use File;

/*
 *
 *
*/

class ObjectController extends Controller
{

  private $file_config = "config.json";

  private $objects = [];

  private $parameters = [];

  private $prototypes = [];

  private $formattedObject = [];


  private function getParameters($parameters){
    $this->parameters = [];
    foreach($parameters as $k => $parameter){
        $this->parameters[$parameter->name->prefix] = $parameter->value;
    }

    return $this->parameters;
  }

  private function getObjects($objects){
      $this->objects = [];
      foreach($objects as $k => $object){
        $this->objects[$object->prefix] = $this->getParameters($object->parameters);
      }

      return $this->objects;
  }

    public function init()
    {

      $this->prototypes = PrototypeName::with("objects.parameters.name")->get();

      foreach ($this->prototypes as $key => $value) {
         $this->formattedObject[$value->prefix] = $this->getObjects($value->objects);
      }
    }

      public function showJsonFromFile(){
          return $this->readFile();
      }

      public function showJson()
      {
          $this->init();
          return response()->json($this->formattedObject);
      }

      public function updateJsonFile(){
        $this->init();
        $data = json_encode($this->formattedObject);
        $this->writeFile($data, $this->file_config);
      }

      ////
      private function writeFile($content, $path){
         return File::put($path, $content);
      }

      private function readFile(){
        return File::get($this->file_config);
      }

}
