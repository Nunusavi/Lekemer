<div class="content-wrapper">
  <section class="content-header">
    <h1> Dashboard <small>Control panel</small> </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <?php if ($_SESSION["profile"] == "Administrator" || $_SESSION["profile"] == "Seller") {
        include "home/top-boxes.php";
      } ?>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <?php if ($_SESSION["profile"] == "Administrator") {
          include "reports/sales-graph.php";
        } ?>
      </div>
      <div class="col-lg-6">
        <?php if ($_SESSION["profile"] == "Administrator") {
          include "reports/bestseller-products.php";
        } ?>
      </div>
      <div class="col-lg-4">
        <?php if ($_SESSION["profile"] == "Administrator") {
          include "reports/sellers.php";
        } ?>
      </div>
      <div class="col-lg-12">
        <?php if ($_SESSION["profile"] == "special" || $_SESSION["profile"] == "seller") {
          echo '<div class="box box-default">
                  <div class="box-header">
                    <h1>Welcome ' . $_SESSION["name"] . '</h1>
                  </div>
                </div>';
        } ?>
      </div>
      <div class="col-lg-12">
        <?php if ($_SESSION["profile"] == "seller") {
          echo '<a href="create-sale">
                  <button class="btn btn-success">
                    <i class="fa fa-plus"></i> Add Sale
                  </button>
                </a>';
          echo '<div class="box">
                  <div class="box-header with-border">
                    <h3 class="box-title">Recent Transactions</h3>
                  </div>
                  <div class="box-body">
                    <table class="table table-bordered table-hover table-striped dt-responsive tables" width="100%">
                      <thead>
                        <tr>
                          <th style="width:10px">#</th>
                          <th>Bill</th>
                          <th>Customer</th>
                          <th>Seller</th>
                          <th>Payment Method</th>
                          <th>Net Cost</th>
                          <th>Total Cost</th>
                          <th>Date</th>
                          <th>Actions</th>
                        </tr>
                      </thead>
                      <tbody>';
          $answer = ControllerSales::ctrSalesDatesRange(null, null);
          if ($answer) {
            foreach ($answer as $key => $value) {
              echo '<tr>';
              echo '<td>' . ($key + 1) . '</td>';
              echo '<td>' . $value["code"] . '</td>';
              $itemCustomer = "id";
              $valueCustomer = $value["idCustomer"];
              $customerAnswer = ControllerCustomers::ctrShowCustomers($itemCustomer, $valueCustomer);
              if ($customerAnswer) {
                echo '<td>' . $customerAnswer["name"] . '</td>';
              } else {
                echo '<td>Unknown</td>';
              }
              $itemUser = "id";
              $valueUser = $value["idSeller"];
              $userAnswer = ControllerUsers::ctrShowUsers($itemUser, $valueUser);
              if ($userAnswer) {
                echo '<td>' . $userAnswer["name"] . '</td>';
              } else {
                echo '<td>Unknown</td>';
              }
              echo '<td>' . $value["paymentMethod"] . '</td>';
              echo '<td>$ ' . number_format($value["netPrice"], 2) . '</td>';
              echo '<td>$ ' . number_format($value["totalPrice"], 2) . '</td>';
              echo '<td>' . $value["saledate"] . '</td>';
              echo '<td>
                      <div class="btn-group">
                        <a class="btn btn-success" href="index.php?route=sales&xml=' . $value["code"] . '">xml</a>
                        <button class="btn btn-warning btnPrintBill" saleCode="' . $value["code"] . '">
                          <i class="fa fa-print"></i>
                        </button>';
              if ($_SESSION["profile"] == "Administrator") {
                echo '<button class="btn btn-primary btnEditSale" idSale="' . $value["id"] . '"><i class="fa fa-pencil"></i></button>
                      <button class="btn btn-danger btnDeleteSale" idSale="' . $value["id"] . '"><i class="fa fa-trash"></i></button>';
              }
              echo '</div>
                    </td>
                    </tr>';
            }
          } else {
            echo '<tr><td colspan="8">No recent transactions found.</td></tr>';
          }
          echo '</tbody>
                    </table>
                  </div>
                </div>';
        } ?>
      </div>
    </div>
  </section>
</div>