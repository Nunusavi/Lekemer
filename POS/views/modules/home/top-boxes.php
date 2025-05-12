<?php

$item = null;
$value = null;
$order = "id";

$sales_controller = new ControllerSales();
$sales = $sales_controller->ctrAddingTotalSales();

$categories_controller = new ControllerCategories();
$categories = $categories_controller->ctrShowCategories($item, $value);
$totalCategories = count($categories);

$customers_controller = new ControllerCustomers();
$customers = $customers_controller->ctrShowCustomers($item, $value);
$totalCustomers = count($customers);

$products_controller = new ControllerProducts();
$products = $products_controller->ctrShowProducts($item, $value, $order);
$totalProducts = count($products);

?>



<div class="col-lg-3 col-xs-6">
	
  <div class="small-box bg-green">
    
    <div class="inner">
      
      <h3><?php echo number_format($sales["total"],2); ?> ETB</h3>

      <p>Sales</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-social-usd"></i>
    
    </div>
    
    <a href="sales" class="small-box-footer">
      
      More info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-primary">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalCategories); ?></h3>

      <p>Categories</p>
    
    </div>
    
    <div class="icon">
    
      <i class="ion ion-clipboard"></i>
    
    </div>
    
    <a href="categories" class="small-box-footer">
      
      More info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-purple">
    
    <div class="inner">
    
      <h3><?php echo number_format($totalCustomers); ?></h3>

      <p>Customers</p>
  
    </div>
    
    <div class="icon">
    
      <i class="ion ion-person-add"></i>
    
    </div>
    
    <a href="customers" class="small-box-footer">

      More info <i class="fa fa-arrow-circle-right"></i>

    </a>

  </div>

</div>

<div class="col-lg-3 col-xs-6">

  <div class="small-box bg-red">
  
    <div class="inner">
    
      <h3><?php echo number_format($totalProducts); ?></h3>

      <p>products</p>
    
    </div>
    
    <div class="icon">
      
      <i class="ion ion-ios-cart"></i>
    
    </div>
    
    <a href="products" class="small-box-footer">
      
      More info <i class="fa fa-arrow-circle-right"></i>
    
    </a>

  </div>
	
</div>