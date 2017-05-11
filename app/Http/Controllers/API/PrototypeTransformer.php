<?php

namespace App\Http\Controllers\API;

use League\Fractal;
use League\Fractal\TransformerAbstract;
use App\Http\Controllers\API\FieldTransformer;
use App\Http\Controllers\API\PrototypeTransformer;

use \League\Fractal\Manager;
use \League\Fractal\Resource\Collection as FractalCollection;

class PrototypeTransformer extends TransformerAbstract {

    public function transform(Prototype $prototype)
    {
        return [
            'id' => (int) $prototype->prototype_id,
            'name' => "Prototype 1",
           "properties" => [] // new Fractal\Resource\Collection($obj, new FieldTransformer);
        ];
    }
}
