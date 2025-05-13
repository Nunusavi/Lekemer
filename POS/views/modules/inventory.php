<?php
include_once 'controllers/products.controller.php';

// Fetch inventory data from the ProductsController
$inventory = controllerProducts::ctrShowProducts(null, null, null);

$totalCost = 0;
foreach ($inventory as $item) {
    $totalCost += $item['buyingPrice'] * $item['stock'];
}
?>

<div class="content-wrapper">

    <section class="content-header">

        <h1>
            Inventory Management
        </h1>

        <ol class="breadcrumb">
            <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Inventory</li>
        </ol>

    </section>

    <section class="content">

        <div class="box">

            <div class="box-header with-border">
                <h2 class="mb-0">Cost of Goods Sold (COGS) Report</h2>
            </div>

            <div class="box-body">

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

                <!-- <input type="hidden" value="<?php echo $_SESSION['profile']; ?>" id="hiddenProfile"> -->

            </div>

        </div>

    </section>

</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>