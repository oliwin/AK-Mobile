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

    private function recursiveChildrenParameters($parameters, $data = array())
    {

        foreach ($parameters as $k => $parameter) {

            if (is_array($parameter["children"]) && count($parameter["children"]) > 0) {

                /* {"Speed":[{"Min Speed":"13"},{"Max Speed":"14"}]} */

                $data[][$parameter["name"]] = $this->recursiveChildrenParameters($parameter["children"]);

            } else {

                /* [{"Min Speed":"10"] */

                $data[] = [$parameter["name"] => $parameter["value"]];
            }
        }

        return $data;
    }

    private function objectParameters($object)
    {

        $parameters = $this->objectsClass->parameters($object);

        $parametersClass = new Parameter();

        $parameters = $parametersClass->iterateChildren($parameters);

        ///////////////////////////////////

        return $this->recursiveChildrenParameters($parameters);
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

            $this->output[$prototype["name"]] = $this->objectsByPrototype($this->prototypesClass->extractStringID($prototype));
        }
    }

    public function _return()
    {

        return $this->output;
    }

}