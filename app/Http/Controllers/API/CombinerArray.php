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

    private function returnParameterName($parameter_id)
    {

        $parameter_id = (string)$parameter_id;

        foreach ($this->parameters as $k => $item) {

            $id = (string)$item["_id"];

            if ($parameter_id === $id) {
                return $item["name"];
            }
        }

    }

    private function objectParameters($object)
    {


        $params = [];

        $id = (string)$object["_id"];

        $parameters = $this->parametersClass->getParametersObject($id);


        foreach ($parameters as $k => $item) {
            
            /* Get parameter details */

            $details = $this->parametersClass->parameterDetails($item["parameter_id"]);

            if (!is_null($details["parent_id"])) {

                $parent_name = $this->returnParameterName($details["parent_id"]);

                $params[$parent_name] = array($details["name"] => $item["value"]);

            } else {

                $data = $this->parametersClass->getType($item["parameter_id"]);

                $name = $data["name"];

                $value = $item["value"];

                $params[$name] = $value;
            }

        }

        return $params;
    }

    private function objectsByPrototype($prototype_id)
    {

        $object_m = [];

        $objects = $this->objectsClass->objectsByPrototype($prototype_id);

        foreach ($objects as $k => $object) {

            $object_m[$object["name"]] = $this->objectParameters($object);
        }

        return $object_m;
    }

    public function _formatOutput()
    {

        foreach ($this->prototypes as $key => $prototype) {

            $prototypeName = $prototype["name"];

            $this->output[$prototypeName] = $this->objectsByPrototype($this->prototypesClass->extractStringID($prototype));
        }
    }

    public function _return()
    {

        return $this->output;
    }

}