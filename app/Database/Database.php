<?php

namespace App\Database;

use PDO;

class Database
{
    private static $instance;
    private $pdo;

    public function __construct()
    {
        $settings = require_once __DIR__ . '/../Settings/Database.php';

        $this->pdo = new PDO('mysql:host=' . $settings['host'] . ';dbname=' . $settings['dbname'],
            $settings['user'],
            $settings['pass']
        );
        
        $this->pdo->exec('SET NAMES utf8mb4 COLLATE utf8mb4_bin');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query($sql, $parameters = [], $class = 'stdClass')
    {
        $prepare = $this->pdo->prepare($sql);
        $execute = $prepare->execute($parameters);
        
        if (!$execute) {
            return null;
        }

        $result = $prepare->fetchAll(PDO::FETCH_CLASS, $class);

        if (!$result) {
            return null;
        }
        
        return $result;
    }
}