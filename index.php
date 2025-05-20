<?php


$page = $_GET['page'] ?? 'home';

$allowedPages = ['home', 'pricing', 'sign-up', 'sign-in', 'admin'];

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