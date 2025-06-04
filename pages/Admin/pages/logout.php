<!-- pages/admin/logout.php -->
<?php
session_start();
session_destroy();
header("Location: ../../index.php?page=admin");
exit;
?>