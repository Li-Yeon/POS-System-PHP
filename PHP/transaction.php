<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];


//Delete Customer
if (isset($_GET['delete'])){
    $idSP = $_GET['delete'];
    //Get ProductID
    $currentProductIDQuery = "SELECT Product_ID from transaction Where No='$idSP'";
    $currentProductIDSqli = mysqli_query($conn, $currentProductIDQuery);
    $currentProductID = mysqli_fetch_assoc($currentProductIDSqli);
    $currentProductID = $currentProductID['Product_ID'];

    //Get Current ID Stock
    $currentProductIDStockQuery = "SELECT Stock from products Where Product_ID='$currentProductID'";
    $currentProductIDStockSqli = mysqli_query($conn, $currentProductIDStockQuery);
    $currentProductIDStock = mysqli_fetch_assoc($currentProductIDStockSqli);
    $currentProductIDStock = $currentProductIDStock['Stock'];

    //Get Deleted Transaction Quantity
    $transDeleteQuantityQuery = "SELECT Quantity from transaction WHERE No='$idSP'";
    $transDeleteQuantitySqli = mysqli_query($conn, $transDeleteQuantityQuery);
    $transDeleteQuantity = mysqli_fetch_assoc($transDeleteQuantitySqli);
    $transDeleteQuantity = $transDeleteQuantity['Quantity'];

    $updatedStock = $currentProductIDStock + $transDeleteQuantity;

    //Update Product Stock
    $updateProductStockQuery = "UPDATE products SET Stock ='$updatedStock' WHERE Product_ID='$currentProductID'";
    $updateProductStockSqli = mysqli_query($conn, $updateProductStockQuery);

    $query = "DELETE FROM transaction WHERE No = '$idSP'";
    $reset = "ALTER TABLE transaction DROP No;ALTER TABLE transaction AUTO_INCREMENT = 1;ALTER TABLE transaction ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query);
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./transaction.php"</script>';
   
}  

?>