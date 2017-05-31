<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:01
 */
class Reader
{

    public $parameters = [];

    public function __construct($file)
    {
        try {

            // $file = basename(__DIR__). "/" . $file;

            foreach (file($file) as $key => $line) {
                $this->parameters[$key] = $this->explodeBy($line);
            }

            $this->removeLastLine($n = 3);

        } catch (\Exception $exception) {
            die("The file doesn't exist");
        }
    }

    private function removeLastLine($n = 1)
    {
        $n = $n * -1;
        array_splice($this->parameters, $n);
    }

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
            // Result::insert($this->values);
        }
    }
}