<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:03
 */

namespace App\Library\Algorithm;

class WorkTypeIndicatorsMatrix
{

    protected $matrix;

    public function __construct()
    {

        $this->fill(1, [1, 2, 4, 5, 7, 9, 10, 12, 18]);
        $this->fill(2, [1, 2, 3, 5, 8, 10, 13, 18]);
        $this->fill(3, [1, 2, 3, 4, 5, 8, 10, 12, 18]);
        $this->fill(4, [1, 2, 4, 5, 7, 8, 11, 13, 18]);
        $this->fill(5, [1, 2, 3, 4, 5, 8, 9, 18]);
        $this->fill(6, [1, 2, 3, 4, 5, 8, 9, 18]);
        $this->fill(7, [1, 2, 3, 5, 8, 12, 14, 18]);
        $this->fill(8, [1, 2, 3, 7, 8, 11, 12, 15, 18]);
        $this->fill(9, [1, 2, 3, 4, 5, 7, 8, 11, 12, 15, 16, 18]);
        $this->fill(10, [1, 2, 3, 4, 7, 8, 15, 18]);
        $this->fill(11, [1, 2, 4, 8, 9, 15, 18]);
        $this->fill(12, [1, 2, 7, 8, 15, 18]);
        $this->fill(13, [1, 2, 4, 6, 7, 11, 16, 17, 18]);
        $this->fill(14, [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18]);

    }

    public function fill($type, $indicators)
    {
        foreach ($indicators as $val) {
            $this->add($type, $val);
        }
    }

    public function add($key, $value)
    {

        $this->matrix[$key][] = $value;
    }

    public function getQMatrix($type)
    {
        return $this->matrix[$type];
    }

}