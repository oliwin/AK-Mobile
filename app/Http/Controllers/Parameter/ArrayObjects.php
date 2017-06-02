<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 6/2/17
 * Time: 1:58 PM
 */

namespace App\Http\Controllers\Parameter;

use App\Http\Controllers\MongoConnection;

use GuzzleHttp\Psr7\Request;

class AbstractArrayObjects extends MongoConnection
{

    protected $array_object = [];

    protected $array_object_parameters = [];

    public function __construct()
    {
        parent::__construct("array_objects_parameters");
    }

    public function _get($selector)
    {

        return $this->get($selector);
    }

}

class ArrayObjects extends AbstractArrayObjects
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get($object_id, $array_object_parameter_id)
    {

        $filter = ["array_object_parameter_id" => $array_object_parameter_id, "object_id" => $object_id];

        $this->array_object = $this->_get($filter);

    }

    public function getObjectParameters()
    {

        $this->array_object_parameters = $this->array_object["parameters"];

    }

    public function add(Request $request, $object_id){

        if(!is_null($request->array_objects)) {

            foreach ($request->array_objects as $item) {

                $parameters["parameters"]["object_id"] = $object_id;
                $parameters["parameters"]["object_array_id"] = $item;
                $parameters["parameters"]["id"][] = array(
                    "name" => "Speed",
                    "value" => 40
                );

            }

            $this->collection->insert($parameters);
        }
    }


}