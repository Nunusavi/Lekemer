<?php
require_once 'Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function createUser($name, $email, $password, $company_id) {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, company_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT), $company_id]);
    }

    public function getLastUserId() {
        return $this->db->lastInsertId();
    }
}
