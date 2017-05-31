<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:03
 */
class Pfz_algorithm extends WorkTypeIndicatorsMatrix
{

    public $O = [];

    public $Z = [];

    public $P = [];

    public $type;

    public $parameters;

    private $file;


    public function __construct($file)
    {
        parent::__construct();

        $this->file = new Reader($file);
    }

    public function porogi()
    {
        $porogi = new Porogi();

        foreach ($this->Z as $k => $v) {
            foreach ($v as $z) {
                $porogi->calculateCategory($z);
                $this->P[] = $porogi->category;
            }
        }
    }

    private function type($arr)
    {

        return (int)current($arr);
    }

    public function output()
    {
        $res = array(
            "O" => $this->O,
            "Z" => $this->Z,
            "P" => $this->P
        );

        echo '<pre>';
        var_dump($res);
    }

    public function calculateZ()
    {

        foreach ($this->file->parameters as $index => $indicator) {
            $z = new FormulaZ($this->type($indicator), $this->O[$index]);
            $z->calculateZ();
            array_push($this->Z, $z->_result());
        }
    }

    public function calculateO()
    {

        foreach ($this->file->parameters as $index => $indicator) {
            
            $type = $this->type($indicator);

            $listO = new FormulaO([
                "parameters" => $this->file->parameters,
                "qMatrix" => $this->getQMatrix($type),
                "type" => $type
            ]);

            $listO->callQFunctions();
            array_push($this->O, $listO->_returnO());
        }
    }
}