<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:01
 */
class FormulaZ
{

    public $Z;

    protected $O = [];

    protected $type;


    public function __construct($type, $O)
    {
        $this->type = $type;
        $this->O = $O;
    }

    private function sumO($O)
    {
        return array_sum($O);
    }

    public function avgO($values)
    {
        return $this->sumO($values) / count($values);
    }

    public function calculateZ()
    {

        $this->Z["Z" . $this->type] = $this->avgO($this->O);
    }

    public function _result()
    {

        return $this->Z;
    }

}