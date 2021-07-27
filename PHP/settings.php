<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];

//Get CompanyInfo
$sql = "SELECT * FROM companydetails";
$getData = mysqli_query($conn, $sql) or die (mysqli_error($conn));

if(isset($_POST['updateCompany']))
{
        $companyName=$_POST['company_Name'];
        $companyAddress=$_POST['company_Address'];
        $companyTel=$_POST['company_Tel'];
        $companyEmail=$_POST['company_Email'];

        //Image
        $target = "uploads/".basename($_FILES['image']['name']);
        $companyLogo = $_FILES['image']['name'];

        $update = "UPDATE companydetails SET CompanyName = '$companyName', CompanyAddress = '$companyAddress', CompanyTel = '$companyTel', CompanyEmail = '$companyEmail', CompanyLogo = 'uploads/CompanyLogo.png'  WHERE No = 1";
        $result = mysqli_query($conn, $update);     

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {

        }
        echo '<script>location.href="./settings.php"</script>';   
}
?>