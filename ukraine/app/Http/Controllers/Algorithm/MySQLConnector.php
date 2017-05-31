<?php

/**
 * Created by PhpStorm.
 * User: Oleg
 * Date: 04.01.2017
 * Time: 22:02
 */
class MySQLConnector
{
    public static $_db;

    public static function connect()
    {
        self::$_db = new MysqliDb ('localhost', 'root', null, 'testukraine');
    }
}