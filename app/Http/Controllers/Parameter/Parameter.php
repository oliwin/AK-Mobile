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
            ['$unset' => ['parameters.' . $id => null, "parameters_type." . $id => null]], ['multiple' => true]);

        $this->collection->update([],['$pop' => ['parameters' => $id]], ['multiple' => true]);

        /* Delete from prototypes */

        $this->changeCollection("prototypes");

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

    public abstract function add();

    public abstract function get($selector);

    public abstract function update($selector, $data);

}

class Parameter extends ParameterAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new ParameterModel();
    }

    public function extractStringID($id)
    {

        return (string)$id["_id"];
    }

    public function add()
    {

        $this->collection->insert($this->document);

    }

    public function get($selector = array())
    {

        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;

        $this->document = iterator_to_array($this->document);

    }

    private function updateRelatons($data, $where){

        // Get previous

        $this->getOne(array("_id", $where["_id"]));

        $prev = array($this->document["name"] => $this->document["value"]);

        ///

        $id = $this->extractStringID($where);

        $this->changeCollection("objects");

        $old_key = key($prev);

        $new_key = $data["name"];

        $v = $prev[$old_key];

        $prev[$new_key] = $v;
        
    }

    public function update($where, $data)
    {

        $this->collection->update($where, $data);

        $this->updateRelatons($data, $where);
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

    public function replaceValuesFromForm($parameters, $parameters_form)
    {

        /* foreach ($parameters["parameters"] as $id => $v){
             dd($parameters_form);
         }*/
    }

    public function getValuesParametersByID($parameters_ids = array())
    {

        $array_with_types = [];

        $array_types = [];

        $values = [];

        $selector = array('_id' => array('$in' => $parameters_ids));

        $this->get($selector);

        foreach ($this->document() as $k => $v) {

            $id = $this->extractStringID($v);

            switch ((int)$v["type"]) {

                case 1:
                    $values[$id] = array($v["name"] => $v["default"]);
                    break;

                case 2:
                    $values[$id] = $this->formatObjects($v["value"]);
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
            "parameters" => $values
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

    private function formatObjects($objects)
    {

        $arr = [];

        foreach ($objects as $k => $v) {

            $arr[$v["name"]] = $v["value"];

        }

        return $arr;
    }
}