<?php

namespace App\Http\Controllers\API;

use File;

use Carbon\Carbon;

/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/13/17
 * Time: 9:12 PM
 */

class ObjectWriterReaderFile
{

    public $file = "config.json";

    private $content;

    public function __construct()
    {
        $this->file = Carbon::now()->format('d-m').'-'.$this->file;
    }


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
