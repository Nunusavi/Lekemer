<?php

use App\Controllers\UsersController;
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