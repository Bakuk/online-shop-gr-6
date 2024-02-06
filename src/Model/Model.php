<?php

namespace Model;

use PDO;
class Model
{
    protected static PDO $pdo;
    public static function getPDO(): PDO
    {
        self::$pdo = new PDO("pgsql:host=db;port=5432;dbname=dbtest", "dbuser", "dbpwd");
        return self::$pdo;
    }
}