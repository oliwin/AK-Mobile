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

        $this->changeCollection("object_parameters");

        $this->collection->remove(["parameter_id" => $id]);

        $this->collection->update(
            ["children" => $id],
            ['$set' => ['children' => null]], ['multiple' => true]);

    }

    public function delete($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $this->collection->remove($selector);

        $this->collection->update(
            [],
            ['$pull' => ['children' => $id]], ['multiple' => true]);

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

        return $this->getOne(array("_id" => $id));

    }

    public function children($parameter)
    {

        $id = $parameter["_id"];

        return $this->get(["parent_id" => $id]);

    }

    public function extractStringID($id)
    {

        return (string)$id["_id"];
    }

    public function add(ParameterModel $parameterModel)
    {

        $data = $parameterModel->data();

        $data_excepted = $parameterModel->except(["_id", "parameters_nested", "errors", "field_array", "parameters_parents"], $data);
        
        $this->collection->insert($data_excepted);

    }

    public function get($selector = array())
    {

        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;

        return $this->document = iterator_to_array($this->document);

    }

    public function update($where, ParameterModel $parameterModel)
    {

        $data = $parameterModel->data();

        $data_excepted = $parameterModel->except(["_id", "parameters_nested", "errors", "field_array", "parameters_parents"], $data);

        $this->collection->update($where, $data_excepted);

    }

    public function search($parameters)
    {
        return $this->get($parameters);

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
        $a = [];

        $data = $this->get(['_id' => ['$in' => $parameters_ids]]);

        $this->document = []; // Required

        $all = $this->all(true);

        /// Iterate all ///

        foreach ($all as $k => $parameter){
            $id = (string)$parameter["_id"];
            $a[$id] = $parameter;
        }

        $all = $a;
    
        //////////////////////////////////////////////////////

        foreach ($data as $k => $value) {

            if (is_array($value['children']) && count($value['children']) > 0) {

                $list[$k] = $value;
                $list[$k]["children"] = $this->getChildren($all, $value['children']);

            } else {

                $list[$k] = $value;
            }
        }

        //dd($list);

       return $list;               
    }


    private function getChildren($data, $childs)
    {

        $list = [];

        foreach ($childs as $k => $child) {

            // $child - is $id

            if (is_array($data[$child]['children'])) {

                $tmpArray = $data[$child];
                $tmpArray['children'] = $this->getChildren($data, $data[$child]['children']);

            } else {

                $tmpArray = $data[$child];
    
            }

            $list[] = $tmpArray;
            $tmpArray = [];
        }

        return $list;
    
    }

    ///////////////////////////

    public function iterateChildren($parameters = array())
    {
        $par = [];

        $children = [];

        $parameterClass = new Parameter();

        foreach ($parameters as $k => $item) {

            $details = $parameterClass->getType($item["parameter_id"]);

            $item["_id"] = $item["parameter_id"];
            $item["name"] = $details["name"];
            $item["type"] = $details["type"];
            $item["prefix"] = $details["prefix"];
            $item["children"] = [];

            if (is_null($item["parent"])) {

                $par[(string)$item["_id"]] = $item;

            } else {

                $children[(string)$item["_id"]] = $item;
            }
        }

        /* Join children to parents */

        foreach ($par as $k => $parent) {

            foreach ($children as $key => $child) {

                if ($parent["parameter_id"] == $child["parent"]) {

                    $id = (string) $child["_id"];
                    $par[$k]['children'][$id] = $child;
                }
            }
        }

        return $par;
    }
}