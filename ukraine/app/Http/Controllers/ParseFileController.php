<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use File;

use App\Result;


class ParseFileController extends Controller
{

    private $values = [];


    public function explodeBy($line, $str = ";")
    {
        $arr = [];
        $items = explode($str, $line);

        foreach ($items as $key => $item) {
            $key = $key + 1;
            $arr["field_" . $key] = $item;
        }

        return $arr;
    }

    public function insert()
    {

        if (!empty($this->values)) {
            Result::insert($this->values);
        }

    }

    public function test()
    {
        try {

            $filename = "file/1.txt";

            foreach (file($filename) as $key => $line) {
                $this->values[$key] = $this->explodeBy($line);
            }

            $this->insert();

        } catch (\Exception $exception) {
            die("The file doesn't exist");
        }
    }
}
