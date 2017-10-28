<?php

namespace Framework;

class DB
{
    private function __construct() {}

    public function query($sql, $params = array())
    {
        $statement = static::connection()->prepare($sql);
        $statement->execute($params);
        $result = $statement->fetch();

        return $result;
    }

    private static function connection()
    {
        return new PDO("mysql:host=localhost;dbname=test", "root", "developer2017");
    }
}