<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 05.01.2017
 * Time: 0:23
 */
class Conclusion
{

    private $conclusions = [];

    public function __construct()
    {
        $this->all();
    }

    public function all()
    {
        $conclusions = MySQLConnector::$_db->get('conclusion');

        foreach ($conclusions as $value) {
            $this->conclusions[$value["type_work"]][$value["category"]] = $value["conclusion"];
        }
    }

    public function get($category, $type){

        return $this->conclusions[$type][$category];
    }
}