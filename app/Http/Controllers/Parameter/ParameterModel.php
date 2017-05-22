<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\AbstractModel;

use Symfony\Component\HttpFoundation\Request;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:40 PM
 */
class ParameterModel extends AbstractModel
{

    protected $name;

    protected $default;

    protected $visibility;

    protected $type;

    protected $only_numbers;

    protected $value;

    public $parameters_nested = [];

    public function fill(Request $request)
    {

        $this->validate($request);

        $this->name = $request->name;

        $this->default = $request->default;

        $this->visibility = $request->visibility;

        $this->only_numbers = $request->only_numbers;

        $this->type = $request->type;

        $this->parameters_nested = $request->parameters;

        /////////////////////////////////////////////

        $this->setValue($request);

    }

    private function setValue($request)
    {

        switch ((int)$request->type) {

            case 1:
                $this->value = $this->default;
                break;

            case 2:
                $this->value = array_keys($this->parameters_nested);
                break;

            case 3:
                $this->value = $request->field_array;
                break;
        }

        if ($this->default == $this->value) {
            $this->type = "1";
        }

        if (is_null($this->value)) {
            $this->value = $this->default;
        }

    }

}