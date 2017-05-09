<?php

namespace App\Http\Controllers\API;

use League\Fractal\TransformerAbstract;

class FieldTransformer extends TransformerAbstract {

    public function transform($obj)
    {
        return [
            'id'     => (int) $obj->id,
            'name' => $obj->name,
            "prototype" => $obj->_prototypes()->get()
        ];
    }
}
