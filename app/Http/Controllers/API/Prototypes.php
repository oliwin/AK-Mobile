<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/15/17
 * Time: 10:39 AM
 */

namespace App\Http\Controllers\API;

use App\PrototypeName;


class Prototypes extends Objects
{

    protected $prototypes = [];


    public function __construct()
    {

        $this->prototypes = PrototypeName::with("objects.parameters.name")->get();

    }

    public function iterate()
    {

        foreach ($this->prototypes as $key => $prototype) {

            $this->prototypes[$prototype->prefix] = $this->fields($prototype);

            $this->addObject($prototype);

        }
    }

    private function fields($prototype){

        return array(
            "id" => $prototype->id,
            "name" => $prototype->name,
            "prefix" => $prototype->prefix
        );
    }

    public function get()
    {

        $arr = parent::get();

        $arr["prototypes"] = $this->prototypes;

        return $arr;
    }

}