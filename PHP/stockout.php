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

if(isset($_POST['dropStock']))
{
        $date=$_POST['date_Out'];
        $product_ID=$_POST['product_ID'];
        $remarks=$_POST['remarks'];
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

        $insert = "INSERT INTO stock_out (Date_Out, Product_ID, Product_Name, Stock, Issued, Remarks) values ('$date', '$product_ID', '$getProductName', '$stock', '$getCurrentUser', '$remarks')";
        $result = mysqli_query($conn, $insert);

        $finalStock = $getCurrentStock - $stock;
        $updateProductQuery = "UPDATE products SET Stock = '$finalStock' WHERE Product_ID ='$product_ID'";
        $updateProductSqli = mysqli_query($conn, $updateProductQuery) or die (mysqli_error($conn)); 
        $reset = "ALTER TABLE stock_out DROP No;ALTER TABLE stock_out AUTO_INCREMENT = 1;ALTER TABLE stock_out ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);  
        $_SESSION['status'] = "Stock successfully dropped!";                 
}

?>