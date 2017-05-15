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

        foreach ($this->parameters as $k => $parameter) {

            $this->fillParametersObject($parameter->object_id, $parameter->name->prefix, $this->value($parameter));
        }
    }

    public function value($parameter)
    {

        /* Complicated parameter with nested properties */

        if ($parameter->type == 1) {

            return $this->parent_children($parameter->parameter_id);
        }

        return (is_null($parameter->value) || empty($parameter->value)) ? $parameter->name->default : $parameter->value;
    }

    private function fillParametersObject($object_id, $parameter_prefix, $value)
    {
        $this->parameters_object[$object_id][$parameter_prefix] = $value;
    }

    public function get()
    {

        return $this->parameters_object;
    }

}