<?php


class MainConnection
{
    public static function connect()
    {
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=shared_db", "root", "");
            $pdo->exec("set names utf8");
            return $pdo;
        } catch (PDOException $e) {
            die("Main DB Connection failed: " . $e->getMessage());
        }
    }
}
