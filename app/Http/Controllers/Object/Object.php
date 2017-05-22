<?php

namespace App\Http\Controllers\Object;

use App\Http\Controllers\MongoConnection;

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

        $this->document = $this->collection->find(array("object_id" =>  $id));

        $this->document = iterator_to_array($this->document);


        $id = (string)$this->inserted["_id"];


        foreach ($this->document as $k => $v){

            $v["object_id"] = $id;

            unset($v["_id"]);

            $this->collection->insert($v);
        }

    }


    public abstract function add(ObjectModel $data);

    public abstract function search($parameters);

    public abstract function get($selector);

    public abstract function update($selector, ObjectModel $data);

}

class Object extends ObjectAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new ObjectModel();
    }

    private function addValues()
    {

        $this->changeCollection("object_parameters");

        $object_id = $this->_insertedID();

        foreach ($this->document["values"] as $type => $arr) {

            foreach ($arr as $_id => $v) {

                $data = [
                    "object_id" => $object_id,
                    "parameter_id" => $_id,
                    "value" => $v
                ];

                $this->collection->insert($data);
            }
        }
    }

    public function add(ObjectModel $objectModel)
    {

        $this->document = $objectModel->data();

        $data_excepted = $objectModel->except(["_id", "selected", "values"], $this->document); /* Contains unique _id for all types -1 */

        $this->collection->insert($data_excepted);

        $this->inserted = $data_excepted;

        $this->addValues();


    }

    public function get($selector = array())
    {

        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;

        $this->document = iterator_to_array($this->document);

    }

    public function update($where, ObjectModel $objectModel)
    {

        $excepted_data = $objectModel->except(["_id", "values"], $objectModel->data());

        $this->collection->update($where, $excepted_data);

        $id = $this->extractStringID($where);

        $this->changeCollection("object_parameters");

        $this->collection->remove(array('object_id' => $id));

        ///////////


        foreach ($objectModel->values() as $type => $arr) {

            foreach ($arr as $_id => $v) {

                $data = [
                    "object_id" => $id,
                    "parameter_id" => $_id,
                    "value" => $v
                ];

                $this->collection->insert($data);
            }
        }

    }

    public function search($parameters)
    {

        $this->get($parameters);

        return $this->document;
    }

    public function objectsByPrototype($prototype_id)
    {

        $selector = array('prototype_id' => $prototype_id);

        $this->get($selector);

        return $this->document;
    }

    public function parameters($object)
    {

        $this->changeCollection("object_parameters");

        $object_id = $this->extractStringID($object);

        $selector = ["object_id" => $object_id];

        $this->get($selector);

        return $this->document;

    }

}