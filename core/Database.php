<?php
// core/Database.php

class Database
{
    private $pdo;

    public function __construct()
    {
        $config = require ROOT . '/config/config.php';
        $dsn = "mysql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['dbname']}";

        try {
            $this->pdo = new PDO($dsn, $config['db']['username'], $config['db']['password']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Could not connect to the database: " . $e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
