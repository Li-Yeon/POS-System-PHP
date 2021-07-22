<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
//User Table
$userQuery = "SELECT * FROM users ORDER BY No ASC";
$userTable = mysqli_query($conn, $userQuery);

?>