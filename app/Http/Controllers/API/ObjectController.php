<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


/*
 *
 *
*/

class ObjectController extends Controller
{


    private $writerReaderFile;

    private $writerReaderDb;

    private $token_access = "b924d4121e4f59582e3ef38532c01ea6";


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

        $results = new CombinerArray();

        $results->_formatOutput();

        return $results->_return();
    }

    ///////////////////////////////////////////

    public function db()
    {
        $array = $this->execute();

        $this->writerReaderDb->add($array);

        return $this->writerReaderDb->read();

    }

    private function checkToken($request)
    {

        if ($request->has("token") && $request->token === $this->token_access) {

            return true;
        }

        false;

    }

    public function update(Request $request)
    {
        if(!$this->checkToken($request)){

            return response()->json("Access forbidden!", 403);
        }

        $array = $this->execute();

        $this->writerReaderFile->write($array);

        echo "Information was updated in file: config.json <br> Call <strong>/config/json</strong>strong> or <strong>/config/db</strong> to display data";

    }

}
