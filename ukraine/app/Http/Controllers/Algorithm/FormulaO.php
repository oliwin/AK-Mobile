<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:02
 */
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
        $this->parameters = current($input["parameters"]);
        $this->qMatrix = $input["qMatrix"];

        if(count($this->parameters) != 150){
            throw new Exception('Wrong number parameters in file. Should be at least 150');
        }
    }

    public function callQFunctions()
    {

        foreach ($this->qMatrix as $n => $q) {

            if ($this->type == 14 && $q == 9) {
                $q = 19;
            }

            $this->t = $this->calculateT_Q($q, $this->parameters);
            $this->k = $this->calculateK($n);
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
                return $this->O1($this->t);
                break;
            case 2:
                return $this->O2($this->t);
                break;
            case 3:
                return $this->O3($this->t);
                break;
            case 4:
                return $this->O4($this->t);
                break;
            case 5:
                return $this->O5($this->t);
                break;
            case 6:
                return $this->O6($this->t);
                break;
            case 7:
                return $this->O7($this->t);
                break;
            case 8:
                return $this->O6($this->t);
                break;
            case 9:
                return $this->O9($this->t);
                break;
            case 10:
                return $this->O10($this->t);
                break;
            case 11:
                return $this->O11($this->t);
                break;
            case 12:
                return $this->O12($this->t);
                break;
            case 13:
                return $this->O13($this->t);
                break;
            case 14:
                return $this->O14($this->t);
                break;
            case 15:
                return $this->O15($this->t);
                break;
            case 16:
                return $this->O16($this->t);
                break;
            case 17:
                return $this->O17($this->t);
                break;
            case 18:
                return $this->O18($this->t);
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

        return $this->calculateO($values) / 3 * $this->k;
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