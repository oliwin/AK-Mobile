<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Object\Object;

/*
 *
 *
*/

class ObjectController extends Controller
{


    private $writerReaderFile;

    private $writerReaderDb;


    public function __construct()
    {

        $this->writerReaderFile = new ObjectWriterReaderFile();
        $this->writerReaderDb = new ObjectWriterReaderDb();

    }

    public function json()
    {
        $this->writerReaderFile->read();

        return $this->writerReaderFile->toJson();
    }

    ///////////////////////////////////

    private function execute()
    {

       $objects = new Object();

       $objects->all();

       return $objects->document();
    }

    ///////////////////////////////////////////

    public function db()
    {
        $array = $this->execute();

        $this->writerReaderDb->add($array);

        return $this->writerReaderDb->read();

    }

    public function update()
    {
        $array = $this->execute();

        $this->writerReaderFile->write($array);

        echo "Information was updated in file: config.json <br> Call <strong>/config/json</strong>strong> or <strong>/config/db</strong> to display data";

    }

}
