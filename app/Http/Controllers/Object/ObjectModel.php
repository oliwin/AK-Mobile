<?php

namespace App\Http\Controllers\Object;

use App\Http\Controllers\AbstractModel;
use App\Http\Controllers\Parameter\Parameter;
use App\Http\Controllers\Prototype\Prototype;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:40 PM
 */
class ObjectModel extends AbstractModel
{

    protected $name;

    protected $category_id;

    protected $prototype_id;

    protected $parameters = [];

    protected $parameters_type = [];


    public function fill(Request $request)
    {
        $this->validate($request);

        $this->name = $request->name;

        $this->category_id = $request->category_id;

        $this->prototype_id = $request->prototype_id;

        $this->setParameters($request);

    }

    private function setParameters($request)
    {

        $prototypeClass = new Prototype();

        $fields_id = $prototypeClass->getFieldsPrototype($this->prototype_id);

        $parametersClass = new Parameter();

        $parameters = $parametersClass->getValuesParametersByID($fields_id);

        $this->parameters = $parameters["parameters"];

        $this->parameters_type = $parameters["types"];

        
        //////////////

        if ($request->has("action") && $request->action == "edit") {

            $parameters_temp = $this->parameters;

            foreach ($parameters_temp as $k => $array) {

                $type = $this->parameters_type[$k];

                if ($type == 3) {

                    $parameters_temp[$k] = $request->parameters[$k];

                } else {

                    foreach ($array as $d => $value) {

                        $parameters_temp[$k][$d] = $request->parameters[$k];

                    }
                }
            }

            $this->parameters = $parameters_temp;
        }
    }


}