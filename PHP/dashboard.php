<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

$currentUser = $_SESSION['currentUser'];
$getCurrentUserQuery = "SELECT Name from users WHERE Username=" . "'" . $currentUser . "'";
$getCurrentUserSqli = mysqli_query($conn, $getCurrentUserQuery);
$getCurrentUser = mysqli_fetch_assoc($getCurrentUserSqli);
$getCurrentUser = $getCurrentUser['Name'];
?>