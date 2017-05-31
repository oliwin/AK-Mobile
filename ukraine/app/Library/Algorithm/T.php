<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:01
 */

namespace App\Library\Algorithm;

use App\Taverage;

use App\Tdeviation;

class T
{
    private $TAvgMatrix;

    private $TAvgMatrixDev;

    private $step = 4;

    protected $T = [
        "Q1" => [15, 17, 19, 21],
        "Q2" => [6],
        "Q3" => [27, 28],
        "Q4" => [25, 26],
        "Q5" => [8, 9, 10, 11, 35, 36, 37],
        "Q6" => [8, 9, 10, 11, 35, 36, 37],
        "Q7" => [8, 9, 10, 11, 35, 36, 37],
        "Q8" => [6, 13, 27, 37],
        "Q9" => [5, 7, 16, 18, 20, 22, 37],
        "Q10" => [30],
        "Q11" => [14],
        "Q12" => [12, 13],
        "Q13" => [34],
        "Q14" => [41, 42],
        "Q15" => [31, 32, 33],
        "Q16" => [24],
        "Q17" => [23],
        "Q18" => [38, 39, 40],
        "Q19" => [5, 7, 16, 18, 20, 22, 27, 29, 32, 37]
    ];

    protected $signs_plus = [6, 12, 24, 26, 30, 31, 33, 38, 39, 40];

    public function __construct()
    {
        $this->TAvgMatrix();
        $this->TAvgMatrixDeviation();
    }

    public function TAvgMatrixDeviation()
    {
        $TAvgItemsDev = Tdeviation::all();

        foreach ($TAvgItemsDev as $value) {
            $this->TAvgMatrixDev[$value->type][$value->T] = $value->avg;
        }
    }

    private function TAvgMatrix()
    {
        $TAvgItems = Taverage::all();

        foreach ($TAvgItems as $value) {
            $this->TAvgMatrix[$value->type][$value->T] = $value->avg;
        }
    }

    private function getTAvgDev($number, $type)
    {
        return isset($this->TAvgMatrixDev[$type][$number]) ? $this->TAvgMatrixDev[$type][$number] : 1;
    }

    private function getTAvg($number, $type)
    {
        return isset($this->TAvgMatrix[$type][$number]) ? $this->TAvgMatrix[$type][$number] : 1;
    }

    public function calculateT_Q($q, $parameters)
    {

        $t_arr = [];
        $t_elements = $this->T["Q" . $q];

        foreach ($t_elements as $t) {
            $t_arr[$t] = trim($parameters["field_" . $t]);
        }

        return $t_arr;
    }

    private function Tsign($key)
    {

        return (!in_array($key, $this->signs_plus)) ? -1 : 1; // $value
    }

    public function formulaT($key, $T)
    {

        //echo "Key: " . $key.'<br>';

       //echo "Input T: " .$T.'<BR>';

         $SR = $this->getTAvg($key, $this->type);
        //echo $SR. '<br>';

         $sign = $this->Tsign($key, $T);

        $SRkvadr = $this->getTAvgDev($key, $this->type);
        //echo $SRkvadr."<br>";

        $T = ((($T - $SR) / $SRkvadr) * 10 * $sign) + 50;

       // echo "T-Output: ". $T.'<br>';

        if($T <= 20){
            $T = 20;
        }

        if($T > 80){
            $T = 80;
        }

        return $T;
    }


}