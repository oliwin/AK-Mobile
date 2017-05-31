<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:03
 */

namespace App\Library\Algorithm;

use App\ResultTest;

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

        return $this->type =  (int)current($arr);
    }

    public function output()
    {
        $res = array(
            "O" => $this->O,
            "Z" => $this->Z,
            "P" => $this->P
        );

        dd($res);
    }

    public function save($transaction){

       foreach($this->O as $k => $v){

           $data[] =
               array(
                   "Z" => current($this->Z[$k]),
                   "O" => json_encode($this->O[$k]),
                   "category" => $this->P[$k],
                   "transaction_id" => $transaction->transaction_id,
                   "client_id" => $transaction->client_id,
                   "type_work" => $this->type
               );
       }

       ResultTest::insert($data);
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

        foreach ($this->file->parameters as $index => $indicators) {

            $type = $this->type($indicators);

            $listO = new FormulaO([
                "parameters" => $indicators,
                "qMatrix" => $this->getQMatrix($type),
                "type" => $type
            ]);

            $listO->callQFunctions();

            array_push($this->O, $listO->_returnO());
        }

    }
}