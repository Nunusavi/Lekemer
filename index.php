<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle direct /paymentverification route
if ($_SERVER['REQUEST_URI'] === '/payment_verification') {
    require_once './pages/payment_verification.php';
    exit;
}

$page = $_GET['page'] ?? 'home';

$allowedPages = ['home', 'pricing', 'sign-up', 'sign-in', 'payment_verification', 'confirm-email', 'verify-email-instructions', 'checkout', 'admin'];

if ($page === 'admin') {
    // Now handle sub-routing inside the admin folder
    $adminPage = $_GET['admin_page'] ?? 'dashboard'; // default admin subpage

    $adminAllowedPages = [
        'dashboard', 'logout', 'login'
    ];

    if (in_array($adminPage, $adminAllowedPages)) {
        include "pages/Admin/pages/{$adminPage}.php";
    } else {
        include "pages/404.php";
    }
} elseif (in_array($page, $allowedPages)) {
    include "pages/{$page}.php";
} else {
    include "pages/404.php";
}
