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

        $this->prototypes = $this->prototypesClass->all(true);
        $this->parameters = $this->parametersClass->all(true);
        $this->objects = $this->objectsClass->all(true);

    }

    private function objectParameters($object)
    {

        $parameters = [];

        foreach ($object["parameters"] as $k => $value) {

            $key = key($value);

            if ($object["parameters_type"][$k] == 2) {

                foreach ($value[$key] as $d => $v) {

                    $arr[$v['name']] = $v["value"];
                }

                $parameters[$key] = $arr;

            } else {

                $parameters[$key] = $value[$key];
            }
        }

        return $parameters;
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