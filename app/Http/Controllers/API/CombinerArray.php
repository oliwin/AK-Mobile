<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/15/17
 * Time: 12:37 PM
 */

namespace App\Http\Controllers\API;

use App\Http\Controllers\Prototype\Prototype;

use App\Http\Controllers\Object\Object;

use App\Http\Controllers\Parameter\Parameter;


class CombinerArray
{
    private $output = [];

    private $objects;

    private $prototypes;

    private $parameters;

    private $prototypesClass;

    private $parametersClass;

    private $objectsClass;

    private $founded = [];

    public function __construct()
    {

        $this->prototypesClass = new Prototype();
        $this->parametersClass = new Parameter();
        $this->objectsClass = new Object();

        $this->prototypesClass->default_filter = array("available" => "1");
        $this->parametersClass->default_filter = array("available" => "1");
        $this->objectsClass->default_filter = array("available" => "1");

        $this->prototypes = $this->prototypesClass->all(true);
        $this->parameters = $this->parametersClass->all(true);
        $this->objects = $this->objectsClass->all(true);

    }

    private function recursiveChildrenParameters($parameters = array(), $parameter_object = array())
    {

        $data = [];


        foreach ($parameters as $k => $parameter) {


            if (is_array($parameter["children"]) && count($parameter["children"]) > 0) {

                if ($parameter["type"] == "2") {

                    /* Objects */

                    $data[$parameter["prefix"]] = $this->recursiveChildrenParameters($parameter["children"], $parameter_object);


                } else if ($parameter["type"] == "6") {

                    /* Array of objects */

                    $data[$parameter["prefix"]][] = $this->recursiveChildrenParameters($parameter["children"], $parameter_object);
                }

            } else {

                /* Scalar */

                $data[$parameter["prefix"]] =  $this->getValue($parameter, $parameter_object);
            }
        }

        return $data;
    }

    /*

    $parameters_in_object - all parameters in object with parameter_id, parent

    */

    private function getValue($parameter, $parameters_in_object)
    {

        //dd($parameters_in_object);

        $id = (string)$parameter["_id"];

        foreach ($parameters_in_object as $k => $p) {

            //////////////

            if ($p["parameter_id"] == $id && !in_array($k, $this->founded)) {

                $this->founded[] = $k;
                
                return $p["value"];
            }
        }


    }

    private function objectParameters($object)
    {

        /* Works */

        $parameters_in_object = $this->objectsClass->parameters($object);

        $parameters_ids = $this->prototypesClass->getFieldsPrototype($object["prototype_id"]);

        $parameters = $this->parametersClass->getValuesParametersByID($parameters_ids);

        return $this->recursiveChildrenParameters($parameters, $parameters_in_object);
    }

    private function objectsByPrototype($prototype_id)
    {

        $object_m = [];

        $objects = $this->objectsClass->objectsByPrototype($prototype_id);

        foreach ($objects as $k => $object){

            $object_m[] = $this->objectParameters($object);
        }

        return $object_m;
    }

    public function _formatOutput()
    {

        foreach ($this->prototypes as $key => $prototype) {

            $this->output[$prototype["prefix"]] = $this->objectsByPrototype($this->prototypesClass->extractStringID($prototype));
        }
    }

    public function _return()
    {

        return $this->output;
    }
}
