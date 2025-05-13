<?php
require_once "../Controller/User.controller.php";

if ($_POST) {
    $companyData = [
        "company_name" => $_POST["company_name"],
        "address" => $_POST["address"],
        "subscription_plan" => $_POST["subscription_plan"]
    ];

    $userData = [
        "full_name" => $_POST["full_name"],
        "email" => $_POST["email"],
        "phone_number" => $_POST["phone_number"],
        "password" => $_POST["password"]
    ];

    $response = UsersController::ctrRegisterUser($companyData, $userData);
    echo json_encode($response);
}
