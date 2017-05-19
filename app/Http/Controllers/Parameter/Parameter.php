<?php

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\MongoConnection;
use Symfony\Component\HttpFoundation\Request;

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

    public function _insertedID()
    {

        return $this->inserted["_id"]->{'$id'};
    }

    public function all()
    {

        $cursor = $this->collection->find()->sort($this->sortBy);

        foreach ($cursor as $id => $value) {
            array_push($this->document, $value);
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

        $new = array('$pull' => array("parameters" => $id));

        $this->changeCollection("prototypes");

        $this->collection->update(array("parameters" => $id), $new);

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

    public function update($where, $data)
    {

        $this->collection->update($where, $data);
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

    public function getValuesParametersByID($parameters_ids = array(), $with_type = false)
    {

        $array_with_types = [];

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
                    $values[$id] = $v["value"];
                    break;
            }

            $array_with_types[$v["type"]][$id] = $values[$id];

        }

        if ($with_type) {
            $values = $array_with_types;
        }

        /* Set as value om object */

        return $values;

    }

    private function formatObjects($objects)
    {

        $arr = [];

        foreach ($objects as $k => $v) {

            $arr[$v["name"]] = $v["value"];

        }

        return $arr;
    }


    public function replaceDefaultValueFromCollection($parameters_collection = array(), $parameters_default = array())
    {

        foreach ($parameters_default as $type => $value) {

            foreach ($value as $k => $v) {

                $key = key($parameters_collection[$k]);

                $parameters_default[$type][$k][$key] = $parameters_collection[$k][$key];
            }
        }

        return $parameters_default;
    }

    public function replaceDefaultValueOnReal(Request $request, $parameters = array())
    {

        if ($request->has("parameters")) {

            foreach ($request->parameters as $k => $v) {

                $key = key($parameters[$k]);

                $parameters[$k][$key] = $v;
            }

        }

        return $parameters;
    }

}