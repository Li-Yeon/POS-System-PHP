<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

$productInfoQuery = "SELECT COUNT(*) AS 'TotalProduct' FROM products";
$pdResult = mysqli_query($conn, $productInfoQuery);
$totalPD = mysqli_fetch_assoc($pdResult);
$totalPD = $totalPD['TotalProduct'];

$customerQuery = "SELECT COUNT(*) AS 'TotalCustomer' FROM customers";
$cstResult = mysqli_query($conn, $customerQuery);
$totalCst = mysqli_fetch_assoc($cstResult);
$totalCst = $totalCst['TotalCustomer'];

//Get Total Stocks
$query = "SELECT SUM(Stock) AS 'Stock' from products";
$StockInRes = mysqli_query($conn, $query);
$StockInVal = mysqli_fetch_assoc($StockInRes);
$StockInSum = (int)$StockInVal['Stock'];
$totalSum = $StockInSum;

$getSumQuery = "SELECT IFNULL( (SELECT SUM(Total) As 'Total' from transaction) ,'Null') As 'Total'";
    $getSumSqli = mysqli_query($conn, $getSumQuery);
    $getSum = mysqli_fetch_assoc($getSumSqli);
    $getSum = $getSum['Total'];
    if ($getSum == 'Null')
    {
        $getSum = "0";
    }

//Top 5 Selling Products
$transQuery = "SELECT Product_Name, Price, SUM(Quantity) As TotalSold FROM transaction GROUP By Product_Name ORDER BY TotalSold DESC LIMIT 0,5";
$transTable = mysqli_query($conn, $transQuery);

//Top Staff
$staffQuery = "SELECT Issued, SUM(Total) As TotalSold FROM transaction GROUP By Issued ORDER BY TotalSold DESC LIMIT 0,5";
$staffTable = mysqli_query($conn, $staffQuery);

//Recent Stock In
$stockInQuery = "SELECT Product_Name, Stock, Supplier FROM stock_in ORDER BY No DESC LIMIT 0,5";
$stockInTable = mysqli_query($conn, $stockInQuery);
?>