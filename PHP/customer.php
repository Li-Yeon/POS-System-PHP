<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Add Customer
if(isset($_POST['addCustomer']))
{
        $cust_Name=$_POST['customer_Name'];
        $cust_Address=$_POST['customer_Address'];
        $cust_Tel=$_POST['customer_Tel'];
        $cust_Email=$_POST['customer_Email'];

        $insertCustQuery = "INSERT INTO customers (Cust_Name, Cust_Address, Cust_Tel, Cust_Email) values ('$cust_Name', '$cust_Address', '$cust_Tel', '$cust_Email')";
        $insertCustSqli = mysqli_query($conn, $insertCustQuery) or die (mysqli_error($conn));
        $reset = "ALTER TABLE customers DROP No;ALTER TABLE customers AUTO_INCREMENT = 1;ALTER TABLE customers ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
        $resetIncrement = mysqli_multi_query($conn, $reset);
        $_SESSION['status'] = "Customer successfully added!";
}

//Delete Customer
if (isset($_GET['delete'])){
    $No = $_GET['delete'];
    $query = "DELETE FROM customers WHERE No = '$No'";
    $reset = "ALTER TABLE customers DROP No;ALTER TABLE customers AUTO_INCREMENT = 1;ALTER TABLE customers ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./customers.php"</script>';
}  

//Get Customer Data
if (isset($_GET['edit'])){
    $idP = $_GET['edit'];
    $query = "SELECT * FROM customers WHERE No = '$idP'";
    $getData = mysqli_query($conn, $query);
}  

//Update Customer Details
if(isset($_POST['editCustomer']))
{
    $cust_Name=$_POST['customer_Name'];
        $cust_Address=$_POST['customer_Address'];
        $cust_Tel=$_POST['customer_Tel'];
        $cust_Email=$_POST['customer_Email'];

    $update = "UPDATE customers SET Cust_Name = '$cust_Name', Cust_Address = '$cust_Address', Cust_Tel = '$cust_Tel', Cust_Email = '$cust_Email'  WHERE No = '$idP'";
    $result = mysqli_query($conn, $update);      
    echo '<script>location.href="./customers.php"</script>';
}
?>