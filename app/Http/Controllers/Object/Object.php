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

    private $sortBy = array("_id" => -1);

    protected $document = [];

    protected $inserted = [];

    public $model;


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

        $cursor = $this->collection->find()->sort($this->sortBy);

        foreach ($cursor as $id => $value) {
            array_push($this->document, $value);
        }

        if($return){

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

    }

    public function cloning($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $clonedObj = $this->getOne($selector);

        $clonedObj = $this->exceptID($clonedObj);

        $this->collection->insert($clonedObj);

        $this->inserted = $clonedObj;


    }


    public abstract function add();

    public abstract function search($parameters);

    public abstract function get($selector);

    public abstract function update($selector, $data);

}

class Object extends ObjectAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new ObjectModel();
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

    public function objectsByPrototype($prototype_id){

        $selector = array('prototype_id' => $prototype_id);

        $this->get($selector);

        return $this->document;
    }

    public function formatParametersWithTypes($object){

        $parameters = $object["parameters"];

        $types = $object["parameters_type"];

        $format = [];

        foreach($parameters as $id => $v){

            $type = $types[$id];

            $format[$type][$id] = $v;
        }
        
        return $format;

    }

}