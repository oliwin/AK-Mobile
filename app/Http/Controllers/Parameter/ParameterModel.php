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


    public function fill(Request $request)
    {

        $this->validate($request);

        $this->name = $request->name;
        
        $this->default = $request->default;

        $this->visibility = $request->visibility;

        $this->only_numbers = $request->only_numbers;

        $this->type = $request->type;

        /////////////////////////////////////////////

        $this->setValue($request);

    }

    private function valueAsObjectFields($request)
    {


        if (is_null($request->field_object)) {
            return $this->default;
        }

        $arr = array();

        $controller = new Parameter();

        foreach ($request->field_object as $k => $v) {

            $keys[] = new \MongoID($k);
        }


        $selector = array('_id' => array('$in' => $keys));

        $controller->get($selector);

        foreach ($controller->document() as $value) {
            $arr[] = $value;
        }

        return $arr;
    }

    private function setValue($request)
    {

        switch ((int)$request->type) {

            case 1:
                $this->value = $this->default;
                break;

            case 2:
                $this->value = $this->valueAsObjectFields($request);
                break;

            case 3:
                $this->value = $request->field_array;
                break;
        }

        if ($this->default == $this->value) {
            $this->type = "1";
        }

    }

}