<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\CombinerArray;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 9:27 PM
 */

class ObjectWriterReaderDb
{

    private $output;


    public function write()
    {
        // Write to Db
    }

    public function read()
    {
        return $this->toJson();

    }

    public function toJson()
    {
        return response($this->output)->header('Content-Type', "json");
    }

    public function add($output)
    {
        $this->output = $output;
    }

}
