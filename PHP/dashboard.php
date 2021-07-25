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
?>