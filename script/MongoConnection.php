<?php
/**
 * Created by Ponomarchuk Oleg
 * Email: ponomarchukov@gmail.com
 * Date: 5/18/17
 * Time: 3:46 PM
 */

namespace App\Http\Controllers;


class MongoConnection
{

    const DB = "game";

    protected $mongo;

    protected $db;

    protected $collection;

    protected $cursor;


    public function __construct($dbcollection, $dbname = null)
    {

        $dbname = (!is_null($dbname)) ? $dbname: self::DB;

        // Connect to MongoDb

        $this->mongo = new \MongoClient();

        // Choose database

        $this->db = $this->mongo->{$dbname};

        // Choose collection

        $this->collection = $this->db->{$dbcollection};

    }

    public function changeCollection($dbcollection)
    {
        $this->collection = $this->db->{$dbcollection};
    }

    public function changeDb($dbname)
    {
        $this->db = $this->mongo->{$dbname};
    }

}