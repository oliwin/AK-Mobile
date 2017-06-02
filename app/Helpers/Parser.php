<?php

use App\Http\Controllers\MongoConnection;


class Parser extends MongoConnection {

    private $date = "2015-05-07";

    private $network = "3G";

    ///////

    private $collection_name = "visitors";

    private $date_field = "created_date";

    private $county_code;


    public function __construct()
    {
        parent::__construct($this->collection_name);
    }

    public function filterByNetwork(){


    }

    public function filterByCountry(){

        $result = $this->collection->get([$this->date => $this->date]);

        dd($result);
    }
}

////////////////

$parser = new Parser();
$parser->filterByCountry();
