<?php


namespace App\Services;

use PDOException;

class Database
{
    public static function start() {
        return self::connect();
    }

    private static function connect() {
        $config = require_once 'config/db.php';

        try{
            $pdo = new \PDO(
                sprintf('mysql:host=%s;dbname=%s', $config['host'], $config['dbname']),
                $config['user'],
                $config['pass']
            );
        }
        catch(PDOException $ex){
            die('Error database connect. Check your config file.');
        }
        return $pdo;
    }
}