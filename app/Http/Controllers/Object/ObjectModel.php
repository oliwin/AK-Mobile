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

    private $temp = [];

    private $parameters_array_key;


    public function fill(Request $request)
    {
        $this->validate($request);

        $this->name = $request->name;

        $this->category_id = $request->category_id;

        $this->prototype_id = $request->prototype_id;

        $this->parameters_array_key = $request->parameters_array_key;

        $this->setParameters($request);

    }

    private function setParameters($request)
    {

        $prototypeClass = new Prototype();

        $fields_id = $prototypeClass->getFieldsPrototype($this->prototype_id);

        $parametersClass = new Parameter();

        $parameters = $parametersClass->getValuesParametersByID($fields_id);

        $this->parameters[] = $parameters["parameters"];

        $this->parameters_type = $parameters["types"];

        dd($this->parameters);

        //////////////

        if ($request->has("action") && $request->action == "edit") {

            $this->edit($request);

            $this->parameters = $this->temp;

        }
    }

    private function edit($request)
    {

        foreach ($request->parameters as $type => $v) {

            switch ($type) {

                case "scalar":
                    $this->_scalar($v);
                    break;

                case "object":
                    $this->_object($v);
                    break;

                case "array":
                    $this->_array($v);
                    break;

            }
        }
    }

    private function _key($v){

        return key($v);
    }

    private function _object($v)
    {

        $this->temp[] = $v;
    }

    private function _array($v)
    {

        $key = $this->_key($v);

        $this->temp[][$key][$this->parameters_array_key] = $v[$key];

    }

    private function _scalar($v)
    {

        $this->temp[] = $v;
    }


}