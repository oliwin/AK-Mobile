<?php

namespace App\Http\Controllers\API;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 7:46 PM
 */
abstract class AbstractObjectParameters
{

    protected $parameters = array();

    protected $parents = array();


    public function add($object){

        $this->parameters = $object;
    }

    public function parent_children($parameter_id){

        return array_key_exists ( $parameter_id , $this->parents ) ? $this[$parameter_id] : [];
    }

    abstract public function parents();

    abstract public function format();

    abstract public function value($value);

}
