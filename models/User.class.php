<?php

/**
 * Created by PhpStorm.
 * User: mrdarky
 * Date: 8/5/16
 * Time: 3:54 PM
 */

class User
{
    private $time;
    private $token;
    private $id;

    public function __construct()
    {
        $this->id = new MongoDB\BSON\ObjectID;
        $this->token = bin2hex(random_bytes(30));
        $this->time = time();
    }

    public function getTime()
    {
        return $this->time;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getId()
    {
        return $this->id;
    }

    public function saveToDB()
    {
        return array([
            '_id' => $this->id,
            'token' => $this->token,
            'time' => $this->time
        ]);
    }

}