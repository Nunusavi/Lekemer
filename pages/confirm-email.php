<?php
require_once __DIR__ . '/../config.php';
require_once PROJECT_ROOT . "/Controllers/UsersController.php";
session_start();

use App\Controllers\UsersController;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification | Lekemer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="assets/css/fontawesome.css">
</head>

<body class="bg-gradient-to-br from-slate-50 to-slate-200 min-h-screen flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full text-center">
        <?php
        if (isset($_GET['token'])) {
            $verified = UsersController::ctrVerifyUserByToken($_GET['token']);
            if ($verified && $verified["status"] === "ok") {
                echo '<pre>'; print_r($_SESSION); echo '</pre>';
                // Set user session (you may want to store more user info as needed)
                $_SESSION['user_id'] = $verified['user_id'] ?? null;
                $_SESSION['user_email'] = $verified['email'] ?? null;
                $_SESSION['company_id'] = $verified['company_id'] ?? null;
                

                echo '<div class="flex justify-center mb-4"><span class="text-green-500 text-6xl"><i class="fa fa-check-circle"></i></span></div>';
                echo '<h3 class="text-2xl font-semibold mb-2 text-gray-800">Email Verified!</h3>';
                echo '<p class="text-gray-500 mb-6">Your email has been successfully verified. You can now proceed to checkout.</p>';
                echo '<a href="checkout" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-full px-6 py-2 transition">Proceed to Checkout</a>';
            } else {
                echo '<div class="flex justify-center mb-4"><span class="text-red-500 text-6xl"><i class="fa fa-times-circle"></i></span></div>';
                echo '<h2 class="text-2xl font-semibold mb-2 text-gray-800">Verification Failed</h2>';
                echo '<p class="text-gray-500 mb-6">' . htmlspecialchars($verified["message"] ?? "Invalid or expired token.") . '</p>';
                echo '<a href="index.php?page=resend-email" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-full px-6 py-2 transition">Resend Confirmation Email</a>';
            }
        } else {
            echo '<div class="flex justify-center mb-4"><span class="text-yellow-400 text-6xl"><i class="fa fa-exclamation-circle"></i></span></div>';
            echo '<h2 class="text-2xl font-semibold mb-2 text-gray-800">Missing Token</h2>';
            echo '<p class="text-gray-500">No verification token was provided.</p>';
        }
        ?>
    </div>
</body>

</html>