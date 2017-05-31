<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 9:20 PM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\Object\ObjectModel;
use App\Http\Controllers\Parameter\ParameterModel;
use App\Http\Controllers\Prototype\PrototypeModel;
use Symfony\Component\HttpFoundation\Request;


class SearchController
{

    const OBJECT = 0;
    const PROTOTYPE = 1;
    const PARAMETER = 2;

    private $keySearch;

    private $parameters;

    private $object;


    public function __construct(Request $request, $object, $condition = "AND")
    {


        $this->object = $object;

        $this->condition($condition);

        /////////////////

        foreach ($request->all() as $parameter => $value) {

            if (property_exists($object->model, $parameter) && !empty($value)) {

                $value = $this->filter($parameter, $value);

                array_push($this->parameters[$this->keySearch], [$parameter => $value]);
            }
        }

    }

    private function filter($parameter, $value)
    {

        if ($parameter == "_id") {

            return $this->_mongoObjectID($value);
        }

        // Search substring in string

        if ($parameter == "name") {

            return new \MongoRegex('/'.$value.'/i');

        }

        return $value;

    }

    private function condition($condition)
    {

        switch ($condition) {

            case "AND":
                $this->keySearch = '$and';
                $this->parameters[$this->keySearch] = array();
                break;

            case "OR":
                $this->keySearch = '$or';
                $this->keySearch[$this->keySearch] = array();
                break;
        }
    }

    private function _mongoObjectID($id)
    {

        return new \MongoId($id);

    }

    public function done()
    {

        if (count($this->parameters[$this->keySearch]) > 0) {
            
            return $this->object->search($this->parameters);
        }
    }

    public static function create($type)
    {

        switch ($type) {
            case self::OBJECT:
                return new Object\Object(ObjectModel::class);
            case self::PROTOTYPE:
                return new Prototype\Prototype(PrototypeModel::class);
            case self::PARAMETER:
                return new Parameter\Parameter(ParameterModel::class);
        }
    }

}