<?php

namespace App\Http\Controllers\Parameter;

use App\Helpers\Helper;
use App\Http\Controllers\MongoConnection;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:39 PM
 */
abstract class ParameterAbstract extends MongoConnection
{

    private $sortBy = array("_id" => -1);

    public $model;

    public $default_filter = array();

    protected $document = [];

    protected $inserted = [];


    public function __construct()
    {
        parent::__construct("parameters");
    }

    public function document()
    {

        return $this->document;
    }

    public function mongoDbID($id)
    {

        return Helper::getMongoIDString($id);
    }

    public function _insertedID()
    {

        return $this->inserted["_id"]->{'$id'};
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

    public function prepare($data)
    {

        $this->document = $data;

    }

    public function getOne($selector)
    {

        return $this->collection->findOne($selector);

    }

    public function deleteRelations($id)
    {
        /* Delete from object that has this category */

        $this->changeCollection("objects");

        $this->collection->update(
            [],
            ['$pull' => ['parameters' => $id]], ['multiple' => true]);
    }

    public function delete($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $this->collection->remove($selector);

        $this->deleteRelations($id);

    }

    public abstract function add(ParameterModel $data);

    public abstract function get($selector);

    public abstract function update($selector, ParameterModel $data);

}

class Parameter extends ParameterAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new ParameterModel();
    }

    public function parameterDetails($id)
    {

        return $this->getType($id);
    }

    public function getType($id)
    {

        $this->changeCollection("parameters");

        $id = new \MongoId($id);

        $result = $this->getOne(array("_id" => $id));

        return $result;

    }

    public function getParametersObject($id)
    {

        $this->changeCollection("object_parameters");

        $this->get(array("object_id" => $id));

        return $this->document;
    }

    public function extractStringID($id)
    {

        return (string)$id["_id"];
    }

    public function add(ParameterModel $parameterModel)
    {

        $this->document = $parameterModel->data();

        $data_excepted = $parameterModel->except(["_id", "parameters_nested"], $this->document);

        $this->collection->insert($data_excepted);

    }

    public function get($selector = array())
    {

        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;

        $this->document = iterator_to_array($this->document);

    }

    public function update($where, ParameterModel $parameterModel)
    {


        $this->document = $parameterModel->data();

        $data_excepted = $parameterModel->except(["_id", "parameters_nested"], $this->document);

        $this->collection->update($where, $data_excepted);


        /* Update nested parameters */

        if (!is_null($parameterModel->parameters_nested)) {

            foreach ($parameterModel->parameters_nested as $k => $v) {

                $where = array('_id' => new \MongoId($k));

                $value = array_first($v);

                $this->collection->update(
                    $where,
                    ['$set' => ["value" => $value]]);
            }
        }

    }

    public function search($parameters)
    {

        $this->get($parameters);

        return $this->document;

    }

    public function convertIdStringToMongoID($array_id = array())
    {

        $keys = [];

        foreach ($array_id as $k => $id) {

            $keys[] = new \MongoId($id);
        }

        return $keys;
    }

    /* $parameters_ids should contain _MongoID type */

    public function getValuesParametersByID($parameters_ids = array())
    {

        $array_with_types = [];

        $array_types = [];

        $values = [];

        $with_name = [];

        $selector = array('_id' => array('$in' => $parameters_ids));

        $this->get($selector);


        foreach ($this->document() as $k => $v) {

            $id = $this->extractStringID($v);

            ///////////
            ////

            switch ((int)$v["type"]) {

                case 1:
                    $values[$id] = array($v["name"] => $v["default"]);
                    break;

                case 2:
                    $values[$id] = $this->formatObjects($v["value"], $v["name"]);
                    break;

                case 3:
                    $values[$id] = $this->formatArray($v["value"], $v["name"]);
                    break;
            }

            $array_types[$id] = (int)$v["type"];
            $array_with_types[$v["type"]][$id] = $values[$id];

        }

        return array(
            "types" => $array_types,
            "parameters_with_type" => $array_with_types,
            "parameters" => $values,
            "with_name" => $with_name
        );

    }

    private function formatArray($objects, $name)
    {

        $arr = [];

        foreach ($objects as $k => $v) {

            $arr[$name][] = $v;

        }

        return $arr;
    }

    private function formatObjects($objects, $name)
    {

        $arr = [];
        $a = [];
        $all = $this->all(true);

        foreach ($all as $k => $v) {
            $arr[(string)$v["_id"]] = $v;
        }

        foreach ($objects as $k => $id) {

            $key = (string)$arr[$id]["_id"];

            $a[$key][$name] = array(
                "name" => $arr[$id]["name"],
                "value" => $arr[$id]["value"]
            );

        }

        return $a;
    }
}