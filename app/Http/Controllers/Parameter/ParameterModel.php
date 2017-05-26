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

    protected $value;

    protected $field_array;

    protected $type_value;

    public $children = [];


    public function fill(Request $request)
    {

        $this->validate($request);

        $this->name = $request->name;

        $this->default = $request->default;

        $this->visibility = $request->visibility;

        $this->type = $request->type;

        $this->children = $request->parameters;

        $this->field_array = $request->field_array;

        $this->type_value = $request->type_value;

        /////////////////////////////////////////////

        $this->setValue();

        $this->validateTypeValue();

        $this->setChildrenParameters();

    }

    private function setChildrenParameters()
    {

        $this->children = (is_array($this->children)) ? array_keys($this->children) : [];

    }

    private function validateTypeValue()
    {

        if ($this->type == "4") {
            $this->type_value = "boolean";
            $this->value = "true";
        }

        if ($this->type == "5") {
            $this->type_value = "float";
        }
    }

    private function setValue()
    {

        switch ((int)$this->type) {

            case 1;
            case 2;
                $this->value = $this->default;
                break;

            case 3;
            case 5;
                $this->value = $this->field_array;
                break;
        }

        if (is_null($this->value)) {
            $this->value = $this->default;
        }

    }

}