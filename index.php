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

if (in_array($page, $allowedPages)) {
    // Check if 'admin' and directory exists
    if ($page === 'admin') {
        // Load index.php inside pages/Admin/
        include "pages/Admin/index.php";
    } else {
        include "pages/$page.php";
    }
} else {
    include "pages/404.php";
}
