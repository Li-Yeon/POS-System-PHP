<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get Category Info
$sql = "SELECT * FROM category ORDER BY No ASC";
$result = mysqli_query($conn, $sql) or die (mysqli_error($conn));

//Delete Product
if (isset($_GET['delete'])){
    $No = $_GET['delete'];
    $query = "DELETE FROM products WHERE No = '$No'";
    $reset = "ALTER TABLE products DROP No;ALTER TABLE products AUTO_INCREMENT = 1;ALTER TABLE products ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./products.php"</script>';
}  

//Get Product Data
if (isset($_GET['edit'])){
    $idP = $_GET['edit'];
    $query = "SELECT * FROM products WHERE No = '$idP'";
    $getData = mysqli_query($conn, $query);
}  

//Update Product Details
if(isset($_POST['editProduct']))
{
    $product_Name=$_POST['product_Name'];
    $category=$_POST['category'];
    $price=$_POST['price'];
    $barcode=$_POST['barcode'];

    $update = "UPDATE products SET Product_Name = '$product_Name', Category = '$category', Barcode = '$barcode', Price = '$price' WHERE No = '$idP'";
    $result = mysqli_query($conn, $update) or die (mysqli_error($conn));    
    echo '<script>location.href="./products.php"</script>';
}
?>