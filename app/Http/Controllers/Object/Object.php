<?php

namespace App\Http\Controllers\Object;

use App\Http\Controllers\MongoConnection;
use App\Http\Controllers\Parameter\Parameter;
use App\Http\Controllers\Parameter\ParameterObject;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:39 PM
 */
abstract class ObjectAbstract extends MongoConnection
{

    public $model;

    public $default_filter = array();

    private $sortBy = array("_id" => -1);

    protected $document = [];

    protected $inserted = [];


    public function __construct()
    {
        parent::__construct("objects");
    }

    public function document()
    {

        return $this->document;
    }

    public function all($return = false)
    {

        $cursor = $this->collection->find($this->default_filter)->sort($this->sortBy);

        foreach ($cursor as $id => $value) {
            array_push($this->document, $value);
        }

        if ($return) {

            return $this->document;
        }
    }

    public function extractStringID($id)
    {

        return (string)$id["_id"];
    }

    private function exceptID($object)
    {

        unset($object["_id"]);

        return $object;

    }

    public function _insertedID()
    {

        return $this->inserted["_id"]->{'$id'};
    }

    public function getOne($selector)
    {

        return $this->collection->findOne($selector);

    }

    public function prepare($data)
    {

        $this->document = $data;

    }

    public function delete($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $this->collection->remove($selector);

        $this->changeCollection("object_parameters");

        $this->collection->remove(["object_id" => $id]);

    }

    public function cloning($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $clonedObj = $this->getOne($selector);

        $clonedObj = $this->exceptID($clonedObj);

        $this->collection->insert($clonedObj);

        $this->inserted = $clonedObj;


        /* Clone object parameters */


        $this->changeCollection("object_parameters");

        $this->document = $this->collection->find(array("object_id" => $id));

        $this->document = iterator_to_array($this->document);

        $id = (string)$this->inserted["_id"];


        foreach ($this->document as $k => $v) {

            $v["object_id"] = $id;

            unset($v["_id"]);

            $this->collection->insert($v);
        }

    }


    public abstract function add(ObjectModel $data, ParameterObject $data);

    public abstract function search($parameters);

    public abstract function get($selector);

    public abstract function update($selector, ObjectModel $data, ParameterObject $data);

}

class Object extends ObjectAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new ObjectModel();
    }

    private function addValues(ParameterObject $parameters, $object_id = null)
    {

        $this->changeCollection("object_parameters");

        $parameters = $parameters->data();

        //////////////////////////////

        /* New parameters dinamycly */

        foreach ($parameters["parameters_new"] as $k => $ids) {

            foreach ($ids as $key => $id) {

                $value = $parameters["values_new"][$k][$key];
                $children = $parameters["children_new"][$k][$key];
                $array_object_id = $parameters["parent_array_object_id"][$key];

                $data = [
                    "object_id" => $object_id,
                    "parameter_id" => $id,
                    "value" => $value,
                    "parent" => $children,
                    "array_object" => $array_object_id
                ];

            }

            $this->collection->insert($data);

        }

        /* Standart parameters */

        foreach ($parameters["parameters"] as $k => $id) {

            $value = $parameters["value"][$k];
            $children = $parameters["children"][$k];

            $data = [
                "object_id" => $object_id,
                "parameter_id" => $id,
                "value" => $value,
                "parent" => $children
            ];

            $this->collection->insert($data);

        }

        /* If incoming data is array */

        if (count($parameters["parameters_array"]) > 0) {

            foreach ($parameters["parameters_array"] as $id => $value) {

                $data_array = [
                    "object_id" => $object_id,
                    "parameter_id" => $id,
                    "value" => $value,
                    "parent" => null
                ];

                $this->collection->insert($data_array);
            }
        }
    }

    public function add(ObjectModel $objectModel, ParameterObject $parameterModel)
    {

        $data = $objectModel->data();

        $data_excepted = $objectModel->except(["_id"], $data);

        $this->collection->insert($data_excepted);

        $this->inserted = $data_excepted;

        $object_id = $this->_insertedID();

        ///////////

        $this->addValues($parameterModel, $object_id);


    }

    public function get($selector = array())
    {


        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;

        return $this->document = iterator_to_array($this->document);

    }

    public function update($where, ObjectModel $objectModel, ParameterObject $parameterObject)
    {

        $excepted_data = $objectModel->except(["_id", "values", "types"], $objectModel->data());

        $this->collection->update($where, $excepted_data);

        $id = $this->extractStringID($where);

        ////////

        $this->changeCollection("object_parameters");

        $this->collection->remove(array('object_id' => $id));

        /// Insert all after reset

        $this->addValues($parameterObject, $id);
    }

    public function search($parameters)
    {

        return $this->get($parameters);
    }

    public function objectsByPrototype($prototype_id)
    {
        $this->changeCollection("objects");

        $selector = array('prototype_id' => $prototype_id);

        return $this->get($selector);

    }

    private function getChildren($object)
    {

        $id = $object["_id"];

        return $this->get(["parent_id" => $id]);
    }

    private function formatArrayKeysMongo($array)
    {

        $mongoKeys = [];

        if (is_array($array)) {
            foreach (array_keys($array) as $k => $id) {
                $mongoKeys[] = new \MongoId($id);
            }
        }

        return $mongoKeys;
    }

    /* NEW FUNCTION */


    public function getDetails($data)
    {
        $details = [];

        $parameters = new Parameter();

        foreach ($data as $k => $id) {

            $id = (string)$id;

            $details[$id] = $parameters->parameterDetails($id);
        }

        return $details;

    }

    public function parametersWithChildren($parameters)
    {

        $details = [];

        $keys_parent = [];

        $array_with_types = [];

        $types = [];

        $values = [];

        $keys = $this->formatArrayKeysMongo($parameters);

        $selector = ['_id' => array('$in' => $keys)];

        $data = $this->get($selector);

        ////////////////////////////

        if (!empty($parameters)) {

            foreach ($parameters as $k => $v) {

                $keys_parent[] = $v["parameter_id"];
            }

            $details = $this->getDetails($keys_parent);
        }

        foreach ($data as $k => $v) {

            $id = $this->extractStringID($v);

            $v["children"] = $this->getChildren($v);
            $v["name"] = $details[$v["parameter_id"]]["name"];

            $types[$id] = (int)$v["type"];
            $array_with_types[$v["type"]][$id] = $v;

        }

        return array(
            "types" => $types,
            "parameters_with_type" => $array_with_types,
            "parameters" => $values
        );

    }


    public function parameters($object)
    {

        $this->changeCollection("object_parameters");

        $object_id = $this->extractStringID($object);

        return $this->get(["object_id" => $object_id]);

    }

}