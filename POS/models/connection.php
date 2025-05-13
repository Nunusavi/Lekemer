<?php
session_start();

if (!isset($_SESSION["company_db"])) {
    die("No database info in session.");
}

$db = $_SESSION["company_db"];

try {
    $pdo = new PDO(
        "mysql:host={$db['host']};dbname={$db['name']}",
        $db["user"],
        $db["password"]
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
