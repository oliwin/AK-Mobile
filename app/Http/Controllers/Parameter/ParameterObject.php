<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/23/17
 * Time: 11:47 AM
 */

namespace App\Http\Controllers\Parameter;

use Symfony\Component\HttpFoundation\Request;

use App\Http\Controllers\AbstractModel;


class ParameterObject extends AbstractModel
{

    protected $object_id;

    protected $parameters_array = [];

    protected $value = [];

    protected $children = [];

    protected $parameters = [];



    public function fill(Request $request)
    {
        $this->object_id = $request->object_id;

        $this->children = $request->children;

        $this->parameters_array = $request->parameters_array;

        $this->value = $request->values;

        $this->parameters = $request->parameters;

    }

}