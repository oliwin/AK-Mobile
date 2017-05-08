<?php

namespace App\Http\Controllers\API;

use League\Fractal\TransformerAbstract;

class ObjectTransformer extends TransformerAbstract {

    public function transform($obj)
    {

      foreach($obj->_prototypes->get() as $k => $v){

        // dd($v->properties()->get()->first()->name);
          dd($v->properties()->get());
      }

        return [
            'id'     => (int) $obj->id,
            'name' => $obj->name,
            "prototype" => $obj->_prototypes()->get()
        ];
    }
}
