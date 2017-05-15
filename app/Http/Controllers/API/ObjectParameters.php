<?php

namespace App\Http\Controllers\API;

use App\FieldRelation;

use App\PrototypeName;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 7:00 PM
 */
class ObjectParameters extends AbstractObjectParameters
{

    private $parameters_object = [];

    public function parents()
    {
        $this->parents = FieldRelation::with("name")->get()->groupBy('parent_id');
    }

    public function format()
    {

        /* Only simple parameters, not nested */

        $this->parameters->filter(function ($item) {
            if ($item->name->type == 2) {
                $this->fillParametersObject($item, $this->value($item));
            }
        });
    }

    public function value($parameter)
    {

        /* Complicated parameter with nested properties */

        $parents = $this->parent_children($parameter->field_id);


        if (count($parents) > 0) {

            $value = $parents;

        } else if (is_null($parameter->value) || empty($parameter->value)) {

            $value = $parameter->name->default;

        } else {

            $value = $parameter->value;
        }

        return $value;

    }

    private function fillParametersObject($parameter, $value)
    {

        $id_object = $parameter->object_id;
        $prefix = $parameter->name->prefix;

        $this->parameters_object[$id_object][$prefix] = $value;

    }

    public function get()
    {

        return $this->parameters_object;
    }

}