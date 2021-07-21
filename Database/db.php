<?php

$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "php_posv3";

$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . nysqli_connect_error());
}

