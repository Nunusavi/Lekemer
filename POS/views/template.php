<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Custom error handler to log errors to the console
set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  $error = [
    'type' => $errno,
    'message' => $errstr,
    'file' => $errfile,
    'line' => $errline
  ];
  echo "<script>console.error(" . json_encode($error) . ");</script>";
  return true; // Prevent the PHP internal error handler from running
});

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>POS System</title> <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="views/img/template/icono-negro.png">
  <link rel="stylesheet" href="views/bower_components/bootstrap/dist/css/bootstrap.min.css"> <!-- Font Awesome -->
  <link rel="stylesheet" href="views/bower_components/font-awesome/css/font-awesome.min.css"> <!-- Ionicons -->
  <link rel="stylesheet" href="views/bower_components/Ionicons/css/ionicons.min.css"> <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/AdminLTE.css"> <!-- AdminLTE Skins -->
  <link rel="stylesheet" href="views/dist/css/skins/_all-skins.min.css"> <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> <!-- DataTables -->
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <link rel="stylesheet" href="views/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css"> <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="views/plugins/iCheck/all.css"> <!-- Daterange picker -->
  <link rel="stylesheet" href="views/bower_components/bootstrap-daterangepicker/daterangepicker.css"> <!-- Morris chart -->
  <link rel="stylesheet" href="views/bower_components/morris.js/morris.css">
  <script src="views/bower_components/jquery/dist/jquery.min.js"></script> <!-- Bootstrap 3.3.7 -->
  <script src="views/bower_components/bootstrap/dist/js/bootstrap.min.js"></script> <!-- FastClick -->
  <script src="views/bower_components/fastclick/lib/fastclick.js"></script> <!-- AdminLTE App -->
  <script src="views/dist/js/adminlte.min.js"></script> <!-- DataTables -->
  <script src="views/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
  <script src="views/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script> <!-- sweet alert -->
  <script src="views/plugins/sweetalert2/sweetalert2.all.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script> <!-- iCheck 1.0.1 -->
  <script src="views/plugins/iCheck/icheck.min.js"></script> <!-- InputMask -->
  <script src="views/plugins/input-mask/jquery.inputmask.js"></script>
  <script src="views/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
  <script src="views/plugins/input-mask/jquery.inputmask.extensions.js"></script> <!-- jQuery Number -->
  <script src="views/plugins/jqueryNumber/jquerynumber.min.js"></script> <!-- daterangepicker http://www.daterangepicker.com/-->
  <script src="views/bower_components/moment/min/moment.min.js"></script>
  <script src="views/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script> <!-- Morris.js charts http://morrisjs.github.io/morris.js/-->
  <script src="views/bower_components/raphael/raphael.min.js"></script>
  <script src="views/bower_components/morris.js/morris.min.js"></script> <!-- ChartJS http://www.chartjs.org/-->
  <script src="views/bower_components/Chart.js/Chart.js"></script>
</head>


<body class="hold-transition skin-red-light sidebar-collapse sidebar-mini login-page">
  <!-- Site wrapper -->
  <?php
  if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] = true) {
    echo '<div class="wrapper">';

    /*=============================================
    =            Header
    =============================================*/
    include "modules/header.php";

    /*=============================================
    =            Sidebar
    =============================================*/
    include "modules/sidebar.php";

    /*=============================================
    =            Content
    =============================================*/
    if (isset($_GET["route"])) {
      $allowedRoutes = [
        'home',
        'users',
        'categories',
        'products',
        'customers',
        'sales',
        'create-sale',
        'edit-sale',
        'reports',
        'inventory',
        'financial-report',
        'logout'
      ];

      if (in_array($_GET["route"], $allowedRoutes)) {
        include "modules/" . $_GET["route"] . ".php";
      } else {
        include "modules/404.php";
      }
    } else {
      include "modules/home.php";
    }

    /*=============================================
    =            Footer
    =============================================*/
    include "modules/footer.php";

    echo '</div>';
  } else {
    header("Location: /Lekemer/pages/sign-in.php");;
    exit;
  }
  ?>
  <!-- ./wrapper -->
  <script src="views/js/template.js"></script>
  <script src="views/js/users.js"></script>
  <script src="views/js/categories.js"></script>
  <script src="views/js/products.js"></script>
  <script src="views/js/customers.js"></script>
  <script src="views/js/sales.js"></script>
  <script src="views/js/reports.js"></script>
</body>

</html>