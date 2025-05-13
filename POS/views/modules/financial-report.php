<?php

require_once "controllers/sales.controller.php";
require_once "controllers/customers.controller.php";
require_once "controllers/products.controller.php";
require_once "controllers/users.controller.php";

require_once "models/sales.model.php";
require_once "models/customers.model.php";
require_once "models/products.model.php";
require_once "models/users.model.php";

?>

<div class="content-wrapper">

    <section class="content-header">
        <h1>Financial Report</h1>
        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Financial Report</li>
        </ol>
    </section>

    <section class="content">

        <!-- Sales Reports -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sales Reports</h3>
            </div>
            <div class="box-body">
                <?php
                $initialDate = null;
                $finalDate = null;

                $sales = ControllerSales::ctrSalesDatesRange($initialDate, $finalDate);

                $arrayDates = array();
                $arraySales = array();
                $addingMonthPayments = array();

                foreach ($sales as $key => $value) {
                    $singleDate = substr($value["saledate"], 0, 7);
                    array_push($arrayDates, $singleDate);
                    if (!isset($addingMonthPayments[$singleDate])) {
                        $addingMonthPayments[$singleDate] = 0;
                    }
                    $addingMonthPayments[$singleDate] += $value["totalPrice"];
                }

                $noRepeatDates = array_unique($arrayDates);
                ?>

                <div class="chart" id="line-chart-Sales" style="height: 250px;"></div>

                <script>
                    var line = new Morris.Line({
                        element: 'line-chart-Sales',
                        resize: true,
                        data: [
                            <?php
                            if ($noRepeatDates != null) {
                                foreach ($noRepeatDates as $date) {
                                    echo "{ y: '" . $date . "', Sales: " . $addingMonthPayments[$date] . " },";
                                }
                                echo "{ y: '" . $date . "', Sales: " . $addingMonthPayments[$date] . " }";
                            } else {
                                echo "{ y: '0', Sales: '0' }";
                            }
                            ?>
                        ],
                        xkey: 'y',
                        ykeys: ['Sales'],
                        labels: ['Sales'],
                        lineColors: ['#3c8dbc', '#f56954', '#00a65a'],
                        lineWidth: 2,
                        hideHover: 'auto',
                        gridTextColor: '#333',
                        gridStrokeWidth: 0.4,
                        pointSize: 4,
                        pointStrokeColors: ['#3c8dbc', '#f56954', '#00a65a'],
                        gridLineColor: '#ccc',
                        gridTextFamily: 'Open Sans',
                        postUnits: ' ETB',
                        gridTextSize: 10
                    });
                </script>
            </div>
        </div>

        <!-- Payment Summaries -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Payment Summaries</h3>
            </div>
            <div class="box-body">
                <?php
                $paymentMethods = array();

                foreach ($sales as $key => $value) {
                    $paymentMethod = $value["paymentMethod"];
                    if (!isset($paymentMethods[$paymentMethod])) {
                        $paymentMethods[$paymentMethod] = 0;
                    }
                    $paymentMethods[$paymentMethod] += $value["totalPrice"];
                }
                ?>

                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Payment Method</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($paymentMethods as $method => $total): ?>
                            <tr>
                                <td><?php echo $method; ?></td>
                                <td><?php echo number_format($total, 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Inventory Reports -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Inventory Reports</h3>
            </div>
            <div class="box-body">
                <?php
                $inventory = controllerProducts::ctrShowProducts(null, null, null);

                $totalCost = 0;
                foreach ($inventory as $item) {
                    $totalCost += $item['buyingPrice'] * $item['stock'];
                }
                ?>

                <p class="lead">Total Cost of Goods: <strong><?php echo number_format($totalCost, 2) . ' ETB'; ?></strong></p>

                <table class="table table-bordered table-hover table-striped dt-responsive productsTable" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Item</th>
                            <th>Stock</th>
                            <th>Buying Price</th>
                            <th>Total Cost</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inventory as $key => $item): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($item['description']); ?></td>
                                <td><?php echo htmlspecialchars($item['stock']); ?></td>
                                <td><?php echo number_format($item['buyingPrice'], 2) . ' ETB'; ?></td>
                                <td><?php echo number_format($item['buyingPrice'] * $item['stock'], 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Customer Reports -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Customer Reports</h3>
            </div>
            <div class="box-body">
                <?php
                $customers = ControllerCustomers::ctrShowCustomers(null, null);
                ?>

                <table class="table table-bordered table-hover table-striped dt-responsive customersTable" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Number of Purchases</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $key => $customer): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                                <td><?php echo number_format($customer['purchases']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Employee Sales Reports -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Employee Sales Reports</h3>
            </div>
            <div class="box-body">
                <?php
                $employees = ControllerUsers::ctrShowUsers(null, null);

                $employeeSales = array();

                foreach ($employees as $employee) {
                    $employeeSales[$employee['id']] = array(
                        'name' => $employee['name'],
                        'totalSales' => 0
                    );
                }

                foreach ($sales as $sale) {
                    $employeeId = $sale['idSeller'];
                    if (isset($employeeSales[$employeeId])) {
                        $employeeSales[$employeeId]['totalSales'] += $sale['totalPrice'];
                    }
                }
                ?>

                <table class="table table-bordered table-hover table-striped dt-responsive employeesTable" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Employee</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employeeSales as $key => $employee): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                <td><?php echo number_format($employee['totalSales'], 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sales Summaries -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Sales Summaries</h3>
            </div>
            <div class="box-body">
                <?php
                $dailySales = array();
                $weeklySales = array();
                $monthlySales = array();

                foreach ($sales as $sale) {
                    $date = new DateTime($sale['saledate']);
                    $day = $date->format('Y-m-d');
                    $week = $date->format('oW');
                    $month = $date->format('Y-m');

                    if (!isset($dailySales[$day])) {
                        $dailySales[$day] = 0;
                    }
                    if (!isset($weeklySales[$week])) {
                        $weeklySales[$week] = 0;
                    }
                    if (!isset($monthlySales[$month])) {
                        $monthlySales[$month] = 0;
                    }

                    $dailySales[$day] += $sale['totalPrice'];
                    $weeklySales[$week] += $sale['totalPrice'];
                    $monthlySales[$month] += $sale['totalPrice'];
                }
                ?>

                <h4>Daily Sales</h4>
                <table class="table table-bordered table-hover table-striped dt-responsive dailySalesTable" width="100%">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dailySales as $date => $total): ?>
                            <tr>
                                <td><?php echo $date; ?></td>
                                <td><?php echo number_format($total, 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h4>Weekly Sales</h4>
                <table class="table table-bordered table-hover table-striped dt-responsive weeklySalesTable" width="100%">
                    <thead>
                        <tr>
                            <th>Week</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($weeklySales as $week => $total): ?>
                            <tr>
                                <td><?php echo $week; ?></td>
                                <td><?php echo number_format($total, 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <h4>Monthly Sales</h4>
                <table class="table table-bordered table-hover table-striped dt-responsive monthlySalesTable" width="100%">
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th>Total Sales</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($monthlySales as $month => $total): ?>
                            <tr>
                                <td><?php echo $month; ?></td>
                                <td><?php echo number_format($total, 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Detailed Transaction Logs -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Detailed Transaction Logs</h3>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-hover table-striped dt-responsive transactionLogsTable" width="100%">
                    <thead>
                        <tr>
                            <th style="width:10px">#</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Employee</th>
                            <th>Payment Method</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $key => $sale): ?>
                            <tr>
                                <td><?php echo $key + 1; ?></td>
                                <td><?php echo htmlspecialchars($sale['saledate']); ?></td>
                                <td><?php echo htmlspecialchars($sale['idCustomer']); ?></td>
                                <td><?php echo htmlspecialchars($sale['idSeller']); ?></td>
                                <td><?php echo htmlspecialchars($sale['paymentMethod']); ?></td>
                                <td><?php echo number_format($sale['totalPrice'], 2) . ' ETB'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </section>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>