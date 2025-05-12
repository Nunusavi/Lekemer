<?php
require_once 'Database.php';

class Company {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createCompany($name, $email, $dbName, $dbUser, $dbPassword) {
        $stmt = $this->db->prepare("INSERT INTO companies (name, email, db_name, db_user, db_password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $dbName, $dbUser, $dbPassword]);
        return $this->db->lastInsertId();
    }

    public function createCompanyDatabase($dbName) {
        $stmt = $this->db->prepare("CREATE DATABASE `$dbName`");
        return $stmt->execute();
    }

    public function applySchemaToCompanyDB($dbName, $schemaPath) {
        $conn = new PDO("mysql:host=localhost;dbname=$dbName", 'root', '');
        $schema = file_get_contents($schemaPath);
        return $conn->exec($schema);
    }
}
