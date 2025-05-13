<?php
require_once "../Controller/User.controller.php";

header('Content-Type: application/json');

if (isset($_POST["email"], $_POST["password"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $response = UsersController::authenticate($email, $password);

    echo json_encode($response);
    exit;
}

echo json_encode(["status" => "error", "message" => "Missing email or password"]);
exit;