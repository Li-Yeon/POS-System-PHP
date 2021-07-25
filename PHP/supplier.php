<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Add Supplier
if(isset($_POST['addSupplier']))
{
        $supplier_ID=$_POST['supplier_ID'];
        $supplier_Name=$_POST['supplier_Name'];
        $supplier_Tel=$_POST['supplier_Tel'];
        $supplier_Email=$_POST['supplier_Email'];
        $supplier_Address=$_POST['supplier_Address'];

        $insertSuppQuery = "INSERT INTO supplier (Supplier_ID, Supplier_Name, Supplier_Tel, Supplier_Email, Supplier_Address) values ('$supplier_ID', '$supplier_Name', '$supplier_Tel', '$supplier_Email', '$supplier_Address')";
        $insertSuppSqli = mysqli_query($conn, $insertSuppQuery) or die (mysqli_error($conn));
        $reset = "ALTER TABLE supplier DROP No;ALTER TABLE supplier AUTO_INCREMENT = 1;ALTER TABLE supplier ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);
        $_SESSION['status'] = "Supplier successfully added!";
}

//Delete Supplier
if (isset($_GET['delete'])){
    $No = $_GET['delete'];
    $query = "DELETE FROM supplier WHERE No = '$No'";
    $reset = "ALTER TABLE supplier DROP No;ALTER TABLE supplier AUTO_INCREMENT = 1;ALTER TABLE supplier ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./suppliers.php"</script>';
}  

//Get Supplier Data
if (isset($_GET['edit'])){
    $idP = $_GET['edit'];
    $query = "SELECT * FROM supplier WHERE No = '$idP'";
    $getData = mysqli_query($conn, $query);
}  

//Update Supplier Details
if(isset($_POST['editSupplier']))
{
        $supplier_ID=$_POST['supplier_ID'];
        $supplier_Name=$_POST['supplier_Name'];
        $supplier_Tel=$_POST['supplier_Tel'];
        $supplier_Email=$_POST['supplier_Email'];
        $supplier_Address=$_POST['supplier_Address'];

    $update = "UPDATE supplier SET Supplier_ID = '$supplier_ID', Supplier_Name = '$supplier_Name', Supplier_Tel = '$supplier_Tel', Supplier_Email = '$supplier_Email' , Supplier_Address = '$supplier_Address'  WHERE No = '$idP'";
    $result = mysqli_query($conn, $update);      
    echo '<script>location.href="./suppliers.php"</script>';

}
?>