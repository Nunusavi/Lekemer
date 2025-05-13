<?php

require_once "../controllers/products.controller.php";
require_once "../models/products.model.php";

class ProductsTableSales {

    /*=============================================
     SHOW PRODUCTS TABLE
    =============================================*/ 
    public function showProductsTableSales() {

        $item = null;
        $value = null;
        $order = "id";

        $products = ControllerProducts::ctrShowProducts($item, $value, $order);

        if (empty($products)) {
            echo '{"data":[]}';
            return;
        }

        $data = array();

        foreach ($products as $index => $product) {

            /*=============================================
            We bring the image
            =============================================*/
            $image = "<img src='{$product["image"]}' width='40px'>";

            /*=============================================
            Stock
            =============================================*/
            if ($product["stock"] <= 10) {
                $stock = "<button class='btn btn-danger'>{$product["stock"]}</button>";
            } elseif ($product["stock"] <= 15) {
                $stock = "<button class='btn btn-warning'>{$product["stock"]}</button>";
            } else {
                $stock = "<button class='btn btn-success'>{$product["stock"]}</button>";
            }

            /*=============================================
            ACTION BUTTONS
            =============================================*/ 
            $buttons = "<div class='btn-group'><button class='btn btn-primary addProductSale recoverButton' idProduct='{$product["id"]}'><i class='fa fa-plus'></i></button></div>";

            $data[] = array(
                $index + 1,
                $image,
                $product["code"],
                $product["description"],
                $stock,
                $buttons
            );
        }

        echo json_encode(array("data" => $data));
    }
}

/*=============================================
ACTIVATE PRODUCTS TABLE
=============================================*/ 
$activateProductsTableSales = new ProductsTableSales();
$activateProductsTableSales->showProductsTableSales();
