<?php
session_start();

use App\Controllers\UsersController;
// get data from user controller 
$email = isset($_SESSION['pending_email']) ? $_SESSION['pending_email'] : '';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email | Lekemer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .email-box {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-indigo-600 py-5 px-6">
            <h1 class="text-2xl font-bold text-white text-center">Almost There!</h1>
        </div>

        <div class="p-6">
            <div class="flex justify-center mb-6">
                <svg class="h-16 w-16 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
            </div>

            <h2 class="text-xl font-semibold text-center text-gray-800 mb-3">Verify Your Email Address</h2>

            <div class="email-box rounded-lg p-4 mb-6 text-center">
                <p class="text-gray-600 mb-2">We sent a verification link to:</p>
                <p class="font-medium text-indigo-600 break-all"><?= htmlspecialchars($email) ?></p>
            </div>

            <p class="text-gray-600 text-sm mb-6">
                Click the link in the email to activate your account. The link will expire in 24 hours.
            </p>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            Can't find the email? Check your spam folder or
                            <a href="#" class="font-medium underline">resend verification</a>.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center">
                <a href="/Lekemer/sign-in" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Return to Sign In
                </a>
            </div>
        </div>

        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <p class="text-xs text-center text-gray-500">
                Didn't register? <a href="/Lekemer/register" class="text-indigo-600 hover:text-indigo-500">Sign up</a>
            </p>
        </div>
    </div>
</body>

</html>