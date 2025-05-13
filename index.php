<?php

$page = $_GET['page'] ?? 'home';

$allowedPages = ['home', 'pricing', 'sign-up', 'sign-in'];

if (in_array($page, $allowedPages)) {
    include "pages/$page.php";
} else {
    include "pages/404.php"; // Optional
}
