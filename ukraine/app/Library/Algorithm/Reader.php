<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:01
 */

namespace App\Library\Algorithm;

use App\Result;

class Reader
{

    public $parameters = [];

    private $fields = [];

    public function __construct($file)
    {
        try {

            foreach (file($file) as $key => $line) {
                $this->parameters[$key] = $this->explodeBy($line);
            }

            $this->removeLastLine();

        } catch (\Exception $exception) {
            die("The file doesn't exist");
        }
    }

    public function getFiled($index)
    {
        $field = [];

        foreach ($this->parameters as $key => $v){
            $field[] = trim($v["field_".$index]);
        }

        return $field;
    }

    public function uniqueCodes(){

        return $this->getFiled(3);
    }

    private function removeLastLine($n = 1)
    {
        $n = $n * -1;
        array_splice($this->parameters, $n);
    }

    public function explodeBy($line, $str = ";")
    {

        $items = explode($str, $line);

        foreach ($items as $key => $item) {
            $key = $key + 1;
            $this->fields["field_" . $key] = $item;
        }

        return $this->fields;
    }

    public function insert()
    {

        if (!empty($this->values)) {
            Result::insert($this->values);
        }
    }
}