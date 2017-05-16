<?php

namespace App\Http\Controllers\API;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 9:01 PM
 */
abstract class ParametersWriter
{

    protected $parameters = [];

    protected $content = [];

    public function add(ObjectParameters $parameters)
    {
        $this->parameters = $parameters;
    }

    abstract public function write();

    abstract public function read();

}
