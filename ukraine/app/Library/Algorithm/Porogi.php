<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:00
 */

namespace App\Library\Algorithm;

class Porogi
{

    public $Z;
    private $limit;
    public $category;

    public function __construct()
    {
        $this->limit = [
            1 => array(44),
            2 => array(44, 44.001),
            3 => array(49, 99),
            4 => array(50),
            5 => array(54, 99),
            6 => array(55)
        ];
    }

    public function calculateCategory($z)
    {

        if ($z < 44) {

            $this->category = 4;

        } else if ($z > 44 && $z < 44.001) {

            $this->selectCategory(null);

        } else if ($z > 44.001 && $z < 49.99) {

            $this->category = 3;

        } else if ($z > 49.99 && $z < 50) {

            $this->selectCategory(null);

        } else if ($z > 50 && $z < 54.99) {

            $this->category = 2;

        } else if ($z > 54.99 && $z < 55) {

            $this->selectCategory(null);

        } else if ($z > 55) {

            $this->category = 1;
        }

    }

    private function selectCategory($Z = array())
    {
        $this->category = $Z;
    }

}