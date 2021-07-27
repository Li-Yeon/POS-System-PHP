<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];


//Delete Product
if (isset($_GET['deleteuser'])){
    $No = $_GET['deleteuser'];
    //Check how many users
    $usercheckSQL = "SELECT COUNT(*) AS Users FROM users;";
    $usercheckSqli = mysqli_query($conn, $usercheckSQL) or die (mysqli_error($conn));
    $usercheck = mysqli_fetch_assoc($usercheckSqli);
    $usercheck = $usercheck['Users'];

    if ($usercheck <= 1) {
        echo '<script>alert("1 user left! Unable to delete.")</script>';
    } else 
    {          
    $query = "DELETE FROM users WHERE No = '$No'";
    $reset = "ALTER TABLE users DROP No;ALTER TABLE users AUTO_INCREMENT = 1;ALTER TABLE users ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resultDelete = mysqli_query($conn, $query) or die (mysqli_error($conn));
    $resetIncrement = mysqli_multi_query($conn, $reset);
    echo '<script>location.href="./users.php"</script>';
    }

}  
?>