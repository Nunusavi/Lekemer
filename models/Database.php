<?php
class Database {
    private static $instance = null;
    private $connection;

    private function __construct() {
        $this->connection = new PDO('mysql:host=localhost;dbname=shared_db', 'root', '');
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}