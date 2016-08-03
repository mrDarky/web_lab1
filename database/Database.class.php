<?php

/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/2/16
 * Time: 8:12 PM
 */

class Database
{
    public $manager;

    public function __construct($ip, $port)
    {
        $manager = new MongoDB\Driver\Manager("mongodb://$ip:$port");
    }

}