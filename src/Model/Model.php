<?php

namespace Model;

use PDO;
class Model
{
    protected static PDO $pdo;

    public static function init(PDO $pdo): void
    {
        static::$pdo = $pdo;
    }
    public static function getPDO(): PDO
    {
        /*$host = getenv('DB_HOST');
        $dbName = getenv('DB_NAME');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');

        self::$pdo = new PDO("pgsql:host=$host;port=5432;dbname=$dbName", $user, $password);
        return self::$pdo;*/

        return self::$pdo;
    }
}