<?php

class MongoConnection
{

    protected $manager;

    protected $db;

    protected $collection;


    public function __construct()
    {

        try {

            $this->manager = new MongoDB\Driver\Manager("mongodb://localhost:27017");

        } catch (MongoDB\Driver\Exception\Exception $e) {

            // TODO
        }
    }

}


///////////


class Parser extends MongoConnection
{

    /* Mongo */

    private $collection_name = "visitors";

    /* Values to change */

    private $date_value = "2015-05-07";

    private $network_value = "ATM";

    /* System settings */

    private $country_field = "country_code";

    private $date_field = "created_date";

    private $network_field = "mobile_carrier";

    private $ip_field = "ip";

    private $output = [];


    public function filter()
    {

        $options = array();

        $filter = [
            $this->date_field => $this->date_value,             /* Where date is */
            $this->network_field => $this->network_value       /* Where network is */
        ];

        $query = new MongoDB\Driver\Query($filter, $options);

        $cursor = $this->manager->executeQuery('db.' . $this->collection_name, $query);

        foreach ($cursor as $value) {
            array_push($this->output, $value);
        }
    }

    public function _output()
    {

        $arr = [];

        $output = [];

        foreach ($this->output as $k => $value) {

            $output[
                $value[
                    $this->country_field
                ]][$value[$this->network_field]][$value[$this->ip_field]
            ] = true;
        }

        foreach ($output as $k => $v) {

            foreach ($v as $c => $t) {

                $arr[$k][$c] = count($t);
            }
        }

        echo '<pre>';

        var_dump($arr);

    }
}

////////////////

$parser = new Parser();
$parser->filter();
$parser->_output();
