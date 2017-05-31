<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:02
 */

namespace App\Library\Algorithm;

class FormulaO extends T
{

    protected $O = [];

    protected $t = [];

    protected $_q;

    protected $type;

    protected $parameters;

    protected $qMatrix;

    protected $k;


    public function __construct($input)
    {
        parent::__construct();

        $this->type = $input["type"];
        $this->parameters = $input["parameters"];
        $this->qMatrix = $input["qMatrix"];

        if(count($this->parameters) != 150){
            throw new \Exception('Wrong number parameters in file. Should be at least 150');
        }
    }

    public function callQFunctions()
    {

        foreach ($this->qMatrix as $n => $q) {

            $this->k = $this->calculateK($n);

            if ($this->type == 14 && $q == 9) {
                $q = 19;
            }

            if($this->type == 9 && $q == 4){
                $this->k = 0.9;
            }

            $this->t = $this->calculateT_Q($q, $this->parameters);
            $this->O["O" . $q] = $this->call($q);

        }

    }

    public function _returnO()
    {
        return $this->O;
    }

    public function calculateK($n)
    {
        $K = new K();
        $m = $this->type;
        $n = $n + 1;

        return $K->getK($m, $n);

    }

    public function call($q)
    {

        switch ($q) {
            case 1:
                $O1 = $this->O1($this->t);
                return $O1;
                break;
            case 2:
                $O2 =  $this->O2($this->t);
                return $O2;
                break;
            case 3:
                $O3 = $this->O3($this->t);
                return $O3;
                break;
            case 4:
                $O4 = $this->O4($this->t);
                return $O4;
                break;
            case 5:
                $O5 = $this->O5($this->t);
                return $O5;
                break;
            case 6:
                $O6 = $this->O6($this->t);
                return $O6;
                break;
            case 7:
                $O7 = $this->O7($this->t);
                return $O7;
                break;
            case 8:
                $O8 = $this->O8($this->t);
                return $O8;
                break;
            case 9:
                $O9 = $this->O9($this->t);
                return $O9;
                break;
            case 10:
                $O10 = $this->O10($this->t);
                return $O10;
                break;
            case 11:
                $O11 = $this->O11($this->t);
                return $O11;
                break;
            case 12:
                $O12 = $this->O12($this->t);
                return $O12;
                break;
            case 13:
                $O13 =  $this->O13($this->t);
                return $O13;
                break;
            case 14:
                $O14 = $this->O14($this->t);
                return $O14;
                break;
            case 15:
                $O15 =$this->O15($this->t);
                return $O15;
                break;
            case 16:
                $O16 = $this->O16($this->t);
                return $O16;
                break;
            case 17:
                $O17 = $this->O17($this->t);
                return $O17;
                break;
            case 18:
                $O18 = $this->O18($this->t);
                return $O18;
                break;
        }
    }

    public function KRange()
    {

        return ($this->k >= 0.7) && ($this->k <= 2) ? true : false;
    }

    public function sumO($arr)
    {

        foreach ($arr as $keyT => $value) {
            $arr[$keyT] = $this->formulaT($keyT, $value);
        }

        return array_sum($arr);
    }

    public function exclude($excluded)
    {

        return array_diff_key($this->O, $excluded);
    }

    public function calculateO($values)
    {

        return self::sumO($values);
    }

    public function O1($values)
    {

        return $this->calculateO($values) / 4 * $this->k;
    }

    public function O2($values)
    {

        return $this->calculateO($values) * $this->k;
    }

    public function O3($values)
    {

        return $this->calculateO($values) / 2 * $this->k;
    }

    public function O4($values)
    {
        return $this->calculateO($values) / 2 * $this->k;
    }

    public function O5($values)
    {

        return $this->calculateO($values) / 7 * $this->k;
    }

    public function O6($values)
    {

        return $this->calculateO($values) / 7 * $this->k;
    }

    public function O7($values)
    {

        return $this->calculateO($values) / 7 * $this->k;
    }

    public function O8($values)
    {

        return $this->calculateO($values) / 4 * $this->k;
    }

    public function O9($values)
    {

        return $this->calculateO($values) / 7 * $this->k;
    }

    public function O10($values)
    {

        return $this->calculateO($values) * $this->k;
    }

    public function O11($values)
    {
        return $this->calculateO($values) * $this->k;
    }

    public function O12($values)
    {
        return $this->calculateO($values) / 2 * $this->k;
    }

    public function O13($values)
    {

        return $this->calculateO($values) * $this->k;
    }

    public function O14($values)
    {
        return $this->calculateO($values) / 2 * $this->k;
    }

    public function O15($values)
    {

        return $this->calculateO($values) / 3 * $this->k;
    }

    public function O16($values)
    {

        return $this->calculateO($values) * $this->k;
    }

    public function O17($values)
    {
        return $this->calculateO($values) * $this->k;
    }

    public function O18($values)
    {
        return $this->calculateO($values) / 3 * $this->k;
    }

    public function O19($values)
    {
        return $this->calculateO($values) / 10 * $this->k;
    }
}