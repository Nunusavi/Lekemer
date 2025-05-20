<!-- pages/admin/logout.php -->
<?php
session_start();
unset($_SESSION['admin_logged_in']);
session_destroy();
header('Location: index.php?page=admin/login');
exit;
