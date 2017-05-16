<?php
/**
 * Created by PhpStorm.
 * User: oleg
 * Date: 5/15/17
 * Time: 12:37 PM
 */

namespace App\Http\Controllers\API;


class CombinerArray
{
    public $output = [];

    private $combined = array();

    public function __construct(Prototypes $prototypes)
    {
        
        $this->combined = $prototypes->get();

    }

    public function _formatOutput()
    {

        foreach ($this->combined["objects"] as $k => $v) {
            foreach ($v as $t => $a) {
                $this->output[$k][$a['prefix']] = (isset($this->combined["parameters"][$a['id']])) ? $this->combined["parameters"][$a['id']] : [];
            }
        }
    }

}