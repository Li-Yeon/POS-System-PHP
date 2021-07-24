<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Category Info
$sql = "SELECT * FROM category ORDER BY No ASC";
$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

if(isset($_POST['addProduct']))
{
        $product_ID=$_POST['product_ID'];
        $product_Name=$_POST['product_Name'];
        $category=$_POST['category'];
        $price=$_POST['price'];
        $barcode=$_POST['barcode'];

        $insertProductQuery = "INSERT INTO products (Product_ID, Product_Name, Category, Price, Barcode) values ('$product_ID', '$product_Name', '$category', '$price', '$barcode')";
        $insertProductSqli = mysqli_query($conn, $insertProductQuery) or die (mysqli_error($conn));
        $reset = "ALTER TABLE products DROP No;ALTER TABLE products AUTO_INCREMENT = 1;ALTER TABLE products ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);
        $_SESSION['status'] = "Product successfully added!";
}


?>