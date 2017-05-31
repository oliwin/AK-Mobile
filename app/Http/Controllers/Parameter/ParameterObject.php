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

    public $errors = [];


    public function fill(Request $request)
    {
        $this->object_id = $request->object_id;

        $this->children = $request->children;

        $this->parameters_array = $request->parameters_array;

        $this->value = $request->values;

        $this->parameters = $request->parameters;

    }

    private function checkParameterType($var, $type)
    {

        switch ($type){

            case "integer":
                return (is_numeric($var));
                break;

            case "string":
                return (is_string($var));
                break;

            case "boolean":
                return (is_bool($var));
                break;

            case "float":
                return (is_float($var));
                break;

            case "vector2":
                return (count($this->parameters_array) == 2);
                break;

            case "vector3":
                return (count($this->parameters_array) == 3);
                break;

            case "object":
            case "array_objects":
                return true;
                break;  
        }


    }

    public function validateValues()
    {

        $this->parameters = (is_null($this->parameters)) ? [] : $this->parameters;

        $parametersClass = new Parameter();

        $data = $parametersClass->getValuesParametersByID($parametersClass->convertIdStringToMongoID($this->parameters));


        ////////////////////
   
        foreach ($this->parameters as $v => $k) {

            $type = $data[$k];
            $value = $this->value[$v];

            if(!$this->checkParameterType($value, $type["type_value"])){
                $this->errors[$value] = "The field ".$v.' should be: '. $type["type_value"];
            }
        }

        return true; // (count($this->errors) > 0) ? false : true;
    }

}