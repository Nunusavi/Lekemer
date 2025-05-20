<?php
session_start();

$pages = $_GET['page'] ?? 'login';

$allowedPages = ['login', 'dashboard', 'logout'];
if (in_array($pages, $allowedPages)) {
    // Load the requested page
    include "pages/Admin/pages/$pages.php";
} else {
    // Redirect to login if the page is not allowed
    include "pages/Admin/pages/dashboard.php";
    exit;
}

// Add other routes as needed