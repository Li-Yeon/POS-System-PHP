<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

    //Product Table
    $productQuery = "SELECT * FROM products ORDER BY No ASC";
    $pdTable = mysqli_query($conn, $productQuery);

    //Category Table
    $categoryQuery = "SELECT * FROM category ORDER BY No ASC";
    $ctTable = mysqli_query($conn, $categoryQuery);

    //User Table
    $userQuery = "SELECT * FROM users ORDER BY No ASC";
    $userTable = mysqli_query($conn, $userQuery);

    //Stock In Table
    $stockInQuery = "SELECT * FROM stock_in ORDER BY No ASC";
    $stockInTable = mysqli_query($conn, $stockInQuery);

    //Stock Out Table
    $stockOutQuery = "SELECT * FROM stock_out ORDER BY No ASC";
    $stockOutTable = mysqli_query($conn, $stockOutQuery);

    //Transaction Table
    $transQuery = "SELECT * FROM transaction ORDER BY Date DESC";
    $transTable = mysqli_query($conn, $transQuery);

    //Supplier Table
    $suppQuery = "SELECT * FROM supplier ORDER BY No ASC";
    $suppTable = mysqli_query($conn, $suppQuery);

    //Customer Table
    $custQuery = "SELECT * FROM customers ORDER BY No ASC";
    $custTable = mysqli_query($conn, $custQuery);

    //Checkout Table
    $checkoutQuery = "SELECT * FROM checkout";
    $checkoutTable = mysqli_query($conn, $checkoutQuery);

?>