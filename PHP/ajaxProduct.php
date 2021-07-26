<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
    if (isset($_POST['productid'])) {
        $productID = $_POST['productid'];
        
        $getPriceQuery = "SELECT Price from products WHERE Product_ID=" . "'" . $productID . "'";
        $getPriceSqli = mysqli_query($conn, $getPriceQuery);
        $getPrice = mysqli_fetch_assoc($getPriceSqli);
        $getPrice = (int)$getPrice['Price'];
        echo $getPrice;
    }

    if (isset($_POST['productID'])) {
        $productID = $_POST['productID'];
        
        $getStockQuery = "SELECT Stock from products WHERE Product_ID=" . "'" . $productID . "'";
        $getStockSqli = mysqli_query($conn, $getStockQuery);
        $getStock = mysqli_fetch_assoc($getStockSqli);
        $getStock = $getStock['Stock'];
        echo $getStock;
    }
?>