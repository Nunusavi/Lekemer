<?php
require_once __DIR__ . '/../vendor/autoload.php'; // <-- Add this line for Composer autoloading
require_once __DIR__ . '/../config.php'; // Correct path to config file
use App\Controllers\UsersController;

// Define PROJECT_ROOT if not already defined
if (!defined('PROJECT_ROOT')) {
    define('PROJECT_ROOT', dirname(__DIR__));
}

ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');
header('Content-Type: application/json');

try {
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

        // Only output JSON, nothing else
        if ($response['status'] === 'ok') {
            error_log("Registration successful: " . (isset($response['message']) ? $response['message'] : 'Unknown success'));
            echo json_encode($response);
        } else {
            error_log("Registration failed: " . (isset($response['message']) ? $response['message'] : 'Unknown error'));
            echo json_encode([
                "status" => "error",
                "message" => $response["message"],
                "console_error" => $response["message"]
            ]);
        }
        // Stop script execution after output
        exit;
    }
} catch (Throwable $e) {
    error_log("Registration error: " . $e->getMessage());
    echo json_encode([
        "status" => "error",
        "message" => $e->getMessage(),
        "console_error" => $e->getMessage()
    ]);
    exit;
}
// Do not add closing PHP tag or any output after this line
