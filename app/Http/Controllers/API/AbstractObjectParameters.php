<?php

namespace App\Http\Controllers\API;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 7:46 PM
 */
abstract class AbstractObjectParameters
{

    protected $parameters = array();

    protected $parents = array();


    public function add($object)
    {

        // Attention here

        $this->parameters[] = $object;

    }

    public function parent_children($field_id){

        $arr = [];
        $parents = $this->parents->toArray();;

        if (array_key_exists ( $field_id , $parents)) {
            foreach($parents[$field_id] as $k => $v) {
                $arr[$v['name']['prefix']] = $v['name']['default'];
            }
        }

        return $arr;
    }

    abstract public function parents();

    abstract public function format();

    abstract public function value($value);

}
