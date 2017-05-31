<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 05.01.2017
 * Time: 0:23
 */

namespace App\Library\Algorithm;

use App\Conclusion;

class Conclusion
{

    private $conclusions = [];

    public function __construct()
    {
        $conclusions = Conclusion::all();

        $this->conclusions = $conclusions->each(function ($item) {
            $this->conclusions[$item->type_work][$item->category] = $item->conclusion;
        });
    }

    public function get($category, $type)
    {

        return $this->conclusions[$type][$category];
    }
}