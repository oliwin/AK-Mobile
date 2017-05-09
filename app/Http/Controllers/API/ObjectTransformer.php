<?php

namespace App\Http\Controllers\API;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use App\Http\Controllers\API\FieldTransformer;
use App\Http\Controllers\API\PrototypeTransformer;

use \League\Fractal\Manager;
use \League\Fractal\Resource\Collection as FractalCollection;
use App\Http\Controllers\API\MyTransformer;

class ObjectTransformer extends MyTransformer  {

    public $fields_allowed = [
      "id",
      "name"
    ];

    public $relation_allowed = ["prototypez"];

    public function __construct($object)
    {
        $this->init($object, $this->fields_allowed, $this->relation_allowed);
    }

    public function output(){
      echo "df";
    }
}
