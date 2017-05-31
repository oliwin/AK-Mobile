<?php

namespace App\Library\Algorithm;

use App\Library\Algorithm\Reader;
use App\Library\Algorithm\Porogi;
use App\Library\Algorithm\T;
use App\Library\Algorithm\FormulaZ;
use App\Library\Algorithm\FormulaO;
use App\Library\Algorithm\WorkTypeIndicatorsMatrix;
use App\Library\Algorithm\Pfz_algorithm;
use App\Library\Algorithm\K;
use App\Library\Algorithm\Conclusion;


class HandleResults
{
    public function __construct($file, $transaction)
    {
        try {

            $init = new Pfz_algorithm($file);

            $init->calculateO();
            $init->calculateZ();
            $init->porogi();

            //$init->output();
            $init->save($transaction);

            //$conclusion = new Conclusion();
            //$conclusion->get(1, 1);

        } catch
        (\Exception $e) {
            echo 'Выброшено исключение: ', $e->getMessage(), "\n";
        }
    }
}