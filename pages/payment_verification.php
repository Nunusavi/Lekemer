<?php
require_once 'Controllers/PaymentController.php';
require_once 'Controllers/UsersController.php';

use App\Controllers\UsersController;

header('Content-Type: text/html; charset=utf-8');

// Handle both GET and JSON POST (for return_url and callback_url)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tx_ref = $_GET['tx_ref'] ?? null;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);
    $tx_ref = $input['tx_ref'] ?? null;
    $status = $input['status'] ?? null;
} else {
    http_response_code(405);
    echo "Method not allowed.";
    exit;
}

if (!$tx_ref) {
    http_response_code(400);
    echo "Invalid request.";
    exit;
}

// 🔍 Call your controller method
$result = PaymentController::verifyPayment($tx_ref);
// echo '<pre>';
// print_r($result);
// echo '</pre>';

// $curl = curl_init();
// curl_setopt_array($curl, array(
//     CURLOPT_URL => 'https://api.chapa.co/v1/transaction/verify/' . urlencode($tx_ref),
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_ENCODING => '',
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'GET',
//     CURLOPT_HTTPHEADER => array(
//         'Authorization: Bearer CHASECK_TEST-s6labTR7g6sm7ReBMFSzYFIwnW6xWpBf'
//     ),
// ));
// $response = curl_exec($curl);
// curl_close($curl);

// $result = json_decode($response, true);

// ✅ Redirect only on success and GET (user return)
if ($result['status']= true) {
    // Start session and store email
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $email = $result['data']['email'] ?? null;
    if ($email) {
        UsersController::getDataFromEmail($email);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Extract company ID from tx_ref
        $parts = explode('-', $tx_ref);
        $company_id = end($parts);

        // Output the loading screen and then success animation
        echo "<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <title>Verifying Payment...</title>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link href='https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css' rel='stylesheet'>
    <style>
        .fade-in { opacity: 0; transition: opacity 0.5s; }
        .fade-in.show { opacity: 1; }
        .checkmark {
            width: 50px;
            height: 50px;
            display: inline-block;
        }
        .checkmark__circle {
            stroke: #22c55e;
            stroke-width: 6;
            fill: none;
            animation: circle 0.6s ease-in-out forwards;
        }
        .checkmark__check {
            stroke: #22c55e;
            stroke-width: 6;
            fill: none;
            stroke-dasharray: 48;
            stroke-dashoffset: 48;
            animation: check 0.4s 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
        }
        @keyframes circle {
            to { stroke-dashoffset: 0; }
        }
        @keyframes check {
            to { stroke-dashoffset: 0; }
        }
    </style>
</head>
<body class='bg-slate-300 min-h-screen flex items-center justify-center'>
    <div id='loading' class='bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center fade-in show'>
        <div class='flex justify-center mb-4'>
            <svg class='animate-spin h-10 w-10 text-blue-500' xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24'>
                <circle class='opacity-25' cx='12' cy='12' r='10' stroke='currentColor' stroke-width='4'></circle>
                <path class='opacity-75' fill='currentColor' d='M4 12a8 8 0 018-8v8z'></path>
            </svg>
        </div>
        <h2 class='text-2xl font-bold text-blue-700 mb-2'>Processing Payment...</h2>
        <p class='text-gray-600 mb-6'>Please wait while we verify your payment.</p>
    </div>
    <div id='success' class='bg-white rounded-xl shadow-lg p-8 max-w-md w-full text-center fade-in' style='display:none;'>
        <div class='flex justify-center p-3 mb-4'>
            <svg class='checkmark' viewBox='0 0 52 52' width='70' height='70' style='background: none; display: block; margin: 0 auto; overflow: visible;'>
                <circle class='checkmark__circle' cx='26' cy='26' r='22' stroke-dasharray='138' stroke-dashoffset='138' style='stroke-linecap: round;'/>
                <path class='checkmark__check' d='M16 27l7 7 13-13' style='stroke-linecap: round;'/>
            </svg>
        </div>
        <h2 class='text-2xl font-bold text-green-600 mb-2'>Payment Verified!</h2>
        <p class='text-gray-600 mb-6'>Redirecting to POS in <span id='countdown'>10</span> seconds...</p>
    </div>
    <script>
        // Animate loading to success
        setTimeout(function() {
            document.getElementById('loading').classList.remove('show');
            setTimeout(function() {
                document.getElementById('loading').style.display = 'none';
                var successDiv = document.getElementById('success');
                successDiv.style.display = '';
                setTimeout(function() {
                    successDiv.classList.add('show');
                }, 10);
                // Animate checkmark
                setTimeout(function() {
                    var circle = document.querySelector('.checkmark__circle');
                    var check = document.querySelector('.checkmark__check');
                    circle.style.strokeDashoffset = 0;
                    check.style.strokeDashoffset = 0;
                }, 100);
                // Countdown and redirect
                var countdown = 5;
                var countdownEl = document.getElementById('countdown');
                var interval = setInterval(function() {
                    countdown--;
                    countdownEl.textContent = countdown;    
                    if (countdown <= 0) {
                        clearInterval(interval);
                        window.location.href = 'http://localhost/Lekemer/sign-in';
                    }
                }, 1000);
            }, 500); // Wait for fade out
        }, 1500); // Simulate verification delay
    </script>
</body>
</html>";
        exit;
    } else {
        // Respond to webhook silently
        http_response_code(200);
        echo json_encode(['message' => 'Webhook handled successfully']);
        exit;
    }
} else {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        // Output error after all headers
        echo "<html><head><title>Payment Failed</title></head><body style='text-align:center;font-family:sans-serif;'>
              <h2>Payment Verification Failed</h2>
              <p>" . htmlspecialchars($result['message'] ?? 'Unknown error') . "</p>
              <script>console.log(" . json_encode($result) . ");</script>
              </body></html>";
    } else {
        http_response_code(400);
        echo json_encode(['error' => $result['message']]);
    }
    exit;
}
