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

    public $default_filter = array();

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

        /* Where available is active = 1 */

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

        return $this->document = $this->collection->findOne($selector);

    }

    //////////////

    public function deleteRelations($id)
    {
        /* Delete from object that has this prototype */

        $this->changeCollection("objects");

        $new = array('$set' => array("prototype_id" => null, "parameters" => [], "parameters_type" => null));

        $this->collection->update(array("prototype_id" => $id), $new);

    }

    public function delete($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $this->collection->remove($selector);

        $this->deleteRelations($id);

    }

    public abstract function add(PrototypeModel $prototypeModel);

    public abstract function get($selector);

    public abstract function update($selector, PrototypeModel $prototypeModel);

}

class Prototype extends PrototypeAbstract
{

    public function __construct()
    {
        parent::__construct();

        $this->model = new PrototypeModel();
    }


    public function add(PrototypeModel $prototypeModel)
    {

        $data_excepted = $prototypeModel->except(["_id"], $prototypeModel->data());

        $this->collection->insert($data_excepted);

    }

    public function get($selector)
    {
        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;
    }

    public function update($where, PrototypeModel $prototypeModel)
    {

        $data_excepted = $prototypeModel->except(["_id"], $prototypeModel->data());

        $this->collection->update($where, $data_excepted);

        $this->updateRelation($data_excepted, $where);


    }

    private function updateRelation($data, $where)
    {


        $id = (string)$where["_id"];

        $this->changeCollection("objects");

        $new = array('$set' => array("parameters" => []));

        $this->collection->update(array("prototype_id" => $id), $new);


        /// Insert

        $data = (!isset($data["parameters"]) || is_null($data["parameters"])) ? [] : $data["parameters"];
        
        $insert = array('$set' => array("parameters" => $data));

        $this->collection->update(array("prototype_id" => $id), $insert);

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

        if (!isset($prototype["parameters"])) {
            return $parameters_ids;
        }

        foreach ($prototype["parameters"] as $k => $v) {

            $parameters_ids[] = new \MongoID($v);
        }


        return $parameters_ids;
    }

}