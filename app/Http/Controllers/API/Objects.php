<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/15/17
 * Time: 11:07 AM
 */

namespace App\Http\Controllers\API;


class Objects extends ObjectParameters
{

    protected $objects = [];


    protected function addObject($objects)
    {

        foreach ($objects->objects as $k => $object) {
        
            $this->add($object->parameters);

            $this->objects[$objects->prefix][$object->prefix] = $this->fields($object);
        }
    }

    private function fields($object){

        return [
            "id" => $object->id,
            "name" => $object->name,
            "prefix" => $object->prefix
        ];
    }

    public function get()
    {
        return array(
            "objects" => $this->objects,
            "parameters"=> parent::get()
        );
    }

}