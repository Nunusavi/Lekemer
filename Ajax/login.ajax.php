<?php

use App\Controllers\UsersController;
require_once __DIR__ . '/../config.php';
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');


header('Content-Type: application/json');
require_once "../Controllers/UsersController.php";

if (isset($_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $response = UsersController::authenticate($email, $password);

    echo json_encode($response);
    exit;
}

echo json_encode(["status" => "error", "message" => "Missing email or password"]);
exit;