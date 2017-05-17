<?php

namespace App\Http\Controllers\API;

use File;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 9:12 PM
 */

class ObjectWriterReaderFile
{

    private $file = "config.json";

    private $content;

    public function write($object)
    {
        $json = json_encode($object);

        File::put($this->file, $json);
    }

    public function read()
    {
        $this->content = File::get($this->file);

    }

    public function toJson()
    {

        return response($this->content)->header('Content-Type', "json");
    }

}
