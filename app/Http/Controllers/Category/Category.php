<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\MongoConnection;

/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 1:46 PM
 */
abstract class CategoryAbstract extends MongoConnection
{

    private $sortBy = array("_id" => -1);

    protected $model;

    protected $document = [];

    

    public function __construct()
    {
        parent::__construct("object_categories");
    }

    public function document()
    {

        return $this->document;
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

        $new = array('$set' => array("category_id" => null));

        $this->changeCollection("objects");

        $this->collection->update(array("category_id" => $id), $new);

    }

    public function delete($id)
    {

        $selector = array('_id' => new \MongoId($id));

        $this->collection->remove($selector);

        $this->deleteRelations($id);

    }

    public abstract function add(CategoryModel $data);

    public abstract function get($selector);

    public abstract function update($selector, $data);

}

class Category extends CategoryAbstract
{

    public function __construct()
    {

        parent::__construct();

        $this->model = new CategoryModel();
    }


    public function get($selector = array())
    {

        $this->cursor = $this->collection->find($selector);

        $this->document = $this->cursor;
    }

    public function update($where, $data)
    {
        $this->collection->update($where, $data);
    }

    public function add(CategoryModel $categoryModel)
    {

        $this->document = $categoryModel->data();

        $data_excepted = $categoryModel->except(["_id"], $this->document);;

        $this->collection->insert($data_excepted);
    }

}