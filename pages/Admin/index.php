<?php
session_start();

// ✅ Redirect to login page if not logged in as admin
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    include 'pages/login.php';
    exit;
}

// ✅ If logged in, get the requested admin subpage
$adminPage = $_GET['admin_page'] ?? 'dashboard';

$adminAllowedPages = [
    'dashboard', 'logout', 'login'];

if (!in_array($adminPage, $adminAllowedPages)) {
    $adminPage = 'dashboard'; // fallback to dashboard
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - <?php echo ucfirst($adminPage); ?></title>
</head>
<body>
    <?php include 'pages/sidebar.php'; ?>
    <div class="main">
        <?php include 'pages/header.php'; ?>
        <?php include "./pages/Admin/{$adminPage}.php"; ?>
    </div>
</body>
</html>
