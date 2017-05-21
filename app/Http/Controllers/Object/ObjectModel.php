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

    protected $values = [];

    public function fill(Request $request)
    {
        $this->validate($request);

        $this->name = $request->name;

        $this->category_id = $request->category_id;

        $this->prototype_id = $request->prototype_id;

        $this->values = $request->parameters;

        $this->setParameters($request);

    }

    public function values(){

        return is_null($this->values) ? [] : $this->values;
    }

    private function setParameters($request)
    {

        if (is_array($request->parameters)) {
            $this->parameters = array_keys($request->parameters);
        }
    }

}