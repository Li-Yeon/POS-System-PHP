<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

    //Product Table
    $productQuery = "SELECT * FROM products ORDER BY No ASC";
    $pdTable = mysqli_query($conn, $productQuery);

    //User Table
    $userQuery = "SELECT * FROM users ORDER BY No ASC";
    $userTable = mysqli_query($conn, $userQuery);

?>