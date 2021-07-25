<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Product Information
$productQuery = "SELECT * FROM products ORDER BY No ASC";
$productRes = mysqli_query($conn, $productQuery);

//Get Supplier Information
$supplierQuery = "SELECT * FROM supplier ORDER BY No ASC";
$supplierRes = mysqli_query($conn, $supplierQuery);

if(isset($_POST['addStock']))
{
        $date=$_POST['date_Entry'];
        $product_ID=$_POST['product_ID'];
        $supplier=$_POST['supplier_ID'];
        $stock=$_POST['stock'];

        //Get Product Name
        $getProductNameQuery = "SELECT Product_Name from products where Product_ID=" . "'" . $product_ID . "'";
        $getProductNameSqli = mysqli_query($conn, $getProductNameQuery);
        $getProductName = mysqli_fetch_assoc($getProductNameSqli);
        $getProductName = $getProductName['Product_Name'];

        //Get Stock
        $getCurrentStockQuery = "SELECT Stock from products where Product_ID=" . "'" . $product_ID . "'";
        $getCurrentStockSqli = mysqli_query($conn, $getCurrentStockQuery);
        $getCurrentStock = mysqli_fetch_assoc($getCurrentStockSqli);
        $getCurrentStock = $getCurrentStock['Stock'];

        $insert = "INSERT INTO stock_in (Date_In, Product_ID, Product_Name, Supplier, Stock, Issued) values ('$date', '$product_ID', '$getProductName', '$supplier', '$stock', '$getCurrentUser')";
        $result = mysqli_query($conn, $insert);

        $finalStock = $getCurrentStock + $stock;
        $updateProductQuery = "UPDATE products SET Stock = '$finalStock' WHERE Product_ID ='$product_ID'";
        $updateProductSqli = mysqli_query($conn, $updateProductQuery) or die (mysqli_error($conn)); 
        $reset = "ALTER TABLE stock_in DROP No;ALTER TABLE stock_in AUTO_INCREMENT = 1;ALTER TABLE stock_in ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);                   
        $_SESSION['status'] = "Stock successfully added!";

}

?>