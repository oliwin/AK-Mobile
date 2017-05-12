<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

use App\Http\Requests;

use Validator;

use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;

use App\PrototypeName;

use File;

use App\FieldRelation;

/*
 *
 *
*/

class ObjectController extends Controller
{

  private $file_config = "config.json";

  private $prototypes = [];

  private $formattedObject = [];

  private $parentRelations = [];


  private function getParameters($params){
    $parameters = [];
    foreach($params as $k => $parameter){
        $default = (is_null($parameter->value) || empty($parameter->value)) ? $parameter->name->default : $parameter->value;
        $parameters[$parameter->name->prefix] = $default; // $this->getChildren($parameter->field_id, $default);
    }

    return $parameters;
  }

  private function getObjects($objects){
     $objects_out = [];
      foreach($objects as $k => $object){
        $objects_out[$object->prefix] = $this->getParameters($object->parameters);
      }

      return $objects_out;
  }

  private function prototypesAll(){
    $this->prototypes = PrototypeName::with("objects.parameters.name")->get();
  }

    public function init()
    {

      $this->parentRelations();
      $this->prototypesAll();

      foreach ($this->prototypes as $key => $value) {
         $this->formattedObject[$value->prefix] = $this->getObjects($value->objects);
      }
    }

      public function showJsonFromFile(){
          return response($this->readFile())->header('Content-Type', "json");
      }

      public function showJson()
      {
          $this->init();

         echo json_encode($this->formattedObject);
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

      /////////////////

      private function parentRelations()
      {
        $realatedFields = FieldRelation::with("name")->get();

        $this->parentRelations = $realatedFields->groupBy('parent_id');

      }

      private function getChildren($field_id, $default_return){

          $all_parent_child_list = $this->rebuildParentRelatonsStructure($this->parentRelations);

          return array_key_exists ( $field_id , $all_parent_child_list ) ? $all_parent_child_list[$field_id] : $default_return;
      }

      private function rebuildParentRelatonsStructure($collection){

        $arr_rebuilt = [];

        foreach($collection as $p_k => $parent){
          foreach($parent as $c_k => $child){
            $arr_rebuilt[$p_k][] = array(
              $child->name->prefix => $child->name->default
            );
          }
        }

        return $arr_rebuilt;

      }

}
