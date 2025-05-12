<?php

$item = null;
$value = null;

$sales = ControllerSales::ctrShowSales($item, $value);
$users = ControllerUsers::ctrShowUsers($item, $value);

$sellerSales = array();

foreach ($sales as $sale) {
  foreach ($users as $user) {
    if ($user["id"] == $sale["idSeller"]) {
      if (!isset($sellerSales[$user["name"]])) {
        $sellerSales[$user["name"]] = 0;
      }
      $sellerSales[$user["name"]] += $sale["netPrice"];
    }
  }
}

?>

<!--=====================================
Sellers
======================================-->

<div class="box box-default">
  <div class="box-header with-border">
  <h3 class="box-title">Sellers</h3>
  </div>
  <div class="box-body">
  <div class="chart-responsive">
    <div class="chart" id="bar-chart1" style="height: 300px;"></div>
  </div>
  </div>
</div>

<script>
  //BAR CHART
  var bar = new Morris.Bar({
  element: 'bar-chart1',
  resize: true,
  data: [
    <?php foreach ($sellerSales as $name => $totalSales): ?>
    { y: '<?php echo $name; ?>', a: '<?php echo $totalSales; ?>' },
    <?php endforeach; ?>
  ],
  barColors: ['#0af'],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Sales'],
  preUnits: '$',
  hideHover: 'auto'
  });
</script>
