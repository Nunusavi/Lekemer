<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . "/Controllers/PaymentController.php";
ini_set('log_errors', 1);
ini_set('error_log', PROJECT_ROOT . '/error.log');
header('Content-Type: application/json');

try {
    // Get and validate input
    $required = ['plan', 'amount', 'email', 'phone'];
    foreach ($required as $field) {
        if (!isset($_POST[$field]) || $_POST[$field] === '') {
            throw new Exception("Missing required field: $field");
        }
    }

    $data = [
        'company_id' => $_POST['company_id'] ?? null,
        'plan' => $_POST['plan'],
        'amount' => (float)$_POST['amount'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone'],
    ];

    // Debug: log $data to help with troubleshooting
    error_log('Payment data: ' . json_encode($data));

    // Process payment
    $result = PaymentController::initiatePayment($data);

    if (!$result['success']) {
        $message = $result['message'] ?? 'Payment processing failed';
        if (is_array($message)) {
            $message = json_encode($message);
        }
        throw new Exception($message);
    }

    // Return success response
    echo json_encode([
        'success' => true,
        'checkout_url' => $result['checkout_url'],
        'payment_id' => $result['payment_id'] ?? null
    ]);
} catch (Exception $e) {
    // Return error response and log the error
    http_response_code(500);
    error_log($e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage(),
        'trace' => $e->getTraceAsString() // For debugging, remove in production
    ]);
}
