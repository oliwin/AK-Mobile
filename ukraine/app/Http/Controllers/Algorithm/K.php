<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:02
 */
class K
{
    private $k_matrix = [];
    private $k_min = 0.7;
    private $k_max = 2.0;
    private $k_default = 1;

    public function __construct()
    {
        $this->getKmatrix();
    }

    public function getK($n, $m)
    {

        return (isset($this->k_matrix[$n][$m]) ? $this->k_matrix[$n][$m] : $this->k_default);
    }

    public function getKmatrix()
    {

        $kItems = MySQLConnector::$_db->get('coefficient_k');

        foreach ($kItems as $key => $value) {
            $n = $key + 1;

            foreach($value as $k => $v){
                $this->k_matrix["type_".$n][$k] = $v;
            }
        }
    }
}