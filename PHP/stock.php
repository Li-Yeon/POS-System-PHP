<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Supplier Info
$sql = "SELECT * FROM supplier ORDER BY No ASC";
$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

//Undo Stock In
if (isset($_GET['delete'])){

    //Get Stock Undo No
    $idStockIn = $_GET['delete'];
    $query = "DELETE FROM stock_in WHERE No = '$idStockIn'";
    $reset = "ALTER TABLE stock_in DROP No;ALTER TABLE stock_in AUTO_INCREMENT = 1;ALTER TABLE stock_in ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";

    $getUndoStockQuery = "SELECT * FROM stock_in WHERE No='$idStockIn'";
    $getUndoStockSqli = mysqli_query($conn, $getUndoStockQuery);
    $getUndoStock = mysqli_fetch_assoc($getUndoStockSqli);
    $getUndoStock = $getUndoStock['Stock'];
    $getUndoIDSqli = mysqli_query($conn, $getUndoStockQuery);       
    $getUndoID = mysqli_fetch_assoc($getUndoIDSqli);  
    $getUndoID = $getUndoID['Product_ID'];
    $getUndoStock = (int)$getUndoStock;

    //Get Stock
    $getCurrentStockQuery = "SELECT Stock from products where Product_ID=" . "'" . $getUndoID . "'";
    $getCurrentStockSqli = mysqli_query($conn, $getCurrentStockQuery);
    $getCurrentStock = mysqli_fetch_assoc($getCurrentStockSqli);
    $getCurrentStock = $getCurrentStock['Stock'];
    $getCurrentStock = (int)$getCurrentStock;
    
    $newStock = $getCurrentStock - $getUndoStock;
    $updateUndoProductQuery = "UPDATE products SET Stock ='$newStock' WHERE Product_ID='$getUndoID'";
    $updateUndoProductSqli = mysqli_query($conn, $updateUndoProductQuery) or die (mysqli_error($conn));
    $resultDelete = mysqli_query($conn, $query);
    $resetIncrement = mysqli_multi_query($conn, $reset);

    echo '<script>location.href="./addstocks.php"</script>';
} 
?>