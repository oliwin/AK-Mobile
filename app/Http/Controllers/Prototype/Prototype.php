<?php

namespace App\Http\Controllers\Prototype;

use App\Helpers\Helper;
use App\Http\Controllers\MongoConnection;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:39 PM
 */
abstract class PrototypeAbstract extends MongoConnection
{

    private $sortBy = array("_id" => -1);

    public $model;

    protected $document = [];


    public function __construct()
    {
        parent::__construct("prototypes");
    }

    public function document()
    {

        return $this->document;
    }

    public function extractStringID($id)
    {

        return (string)$id["_id"];
    }

    public function all($return = false)
    {

        $cursor = $this->collection->find()->sort($this->sortBy);

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

        return $this->document = $this->collection->findOne($selector);

    }

    //////////////

    public function deleteRelations($id)
    {
        /* Delete from object that has this prototype */

        $new = array('$set' => array("prototype_id" => null));

        $this->changeCollection("objects");

        $this->collection->update(array("prototype_id" => $id), $new);

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

class Prototype extends PrototypeAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new PrototypeModel();
    }


    public function add()
    {

        $this->collection->insert($this->document);

    }

    public function get($selector)
    {
        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;
    }

    public function updateRelations($data = array(), $id)
    {

        $id = (string)$id["_id"];

        $this->getOne(array("_id" => Helper::getMongoIDString($id)));

        $collection = array_flip($this->document["parameters"]);

        $selected = array_flip($data["parameters"]);

        $diff = array_diff_key($selected, $collection);

        //////////////////

        $this->changeCollection("parameters");

        $newdata = [];


        foreach ($diff as $id_parameter => $v) {

            $parameter = $this->getParametersDetails($id_parameter);

            $newdata[] = array($id_parameter => array($parameter["name"] => $parameter["value"]));

            $types[$id_parameter] = $parameter["type"];

        }

        ///////////////////

        $this->changeCollection("objects");

        foreach ($newdata as $k => $v) {

            foreach ($v as $key => $data) {

                $this->collection->update(
                    ["prototype_id" => $id],
                    ['$set' => ["parameters." . $key => $data]],
                    ["multiple" => true]);

                $this->collection->update(
                    ["prototype_id" => $id],
                    ['$set' => ["parameters_type." . $key => $types[$key]]],
                    ["multiple" => true]);
            }

        }

    }

    private function getParametersDetails($id_parameter)
    {

        $selector = array('_id' => new \MongoId($id_parameter));

        return $this->getOne($selector);

    }

    public function update($where, $data)
    {
        $this->updateRelations($data, $where);

        $this->changeCollection("prototypes");

        $this->collection->update($where, $data);


    }

    public function search($parameters)
    {

        $this->get($parameters);

        return $this->document;
    }

    public function getFieldsPrototype($prototype_id)
    {

        $parameters_ids = [];

        $selector = array('_id' => new \MongoId($prototype_id));

        $prototype = $this->getOne($selector);

        foreach ($prototype["parameters"] as $k => $v) {

            $parameters_ids[] = new \MongoID($v);
        }


        return $parameters_ids;
    }

}