<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

//Truncate Products
$truncateProductSQL = "TRUNCATE TABLE products";
$truncateProduct = mysqli_query($conn, $truncateProductSQL); 

//Truncate Category
$truncateCategorySQL = "TRUNCATE TABLE category";
$truncateCategory = mysqli_query($conn, $truncateCategorySQL);

//Truncate Stock In
$truncateStockInSQL = "TRUNCATE TABLE stock_in";
$truncateStockIn = mysqli_query($conn, $truncateStockInSQL); 

//Truncate Stock Out
$truncateStockOutSQL = "TRUNCATE TABLE stock_out";
$truncateStockOut = mysqli_query($conn, $truncateStockOutSQL); 

//Truncate Suppliers
$truncateSuppliersSQL = "TRUNCATE TABLE supplier";
$truncateSuppliers= mysqli_query($conn, $truncateSuppliersSQL); 

//Truncate Transaction
$truncateTransactionSQL = "TRUNCATE TABLE transaction";
$truncateTransaction = mysqli_query($conn, $truncateTransactionSQL); 

//Truncate Customers
$truncateCustomersSQL = "TRUNCATE TABLE customers";
$truncateCustomers = mysqli_query($conn, $truncateCustomersSQL); 

echo '<script>location.href="../index.php"</script>';

?>