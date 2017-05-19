<?php


class MongoConnection
{

    private $mongo;

    private $db;

    private $collection;

    public function __construct($dbname, $dbcollection)
    {
        // Connect to MongoDb
        $this->mongo = new MongoClient();

        // Choose database
        $this->db = $this->mongo->{$dbname};

        // Choose collection
        $this->collection = $this->db->{$dbcollection};

    }

    public function changeCollection($dbcollection)
    {
        $this->_collection = $this->db->{$dbcollection};
    }

    public function changeDb($dbname)
    {
        $this->db = $this->mongo->{$dbname};
    }

}

?>
