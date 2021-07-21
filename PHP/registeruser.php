<?php

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];

    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Functions/loginFunction.php';

    if (invalidUid($username) !== false){
        echo '<script>alert("Invalid username!")</script>';
        echo '<script>location.href="registeruser.php?error=invaliduid"</script>';
        exit();
    }
    if (uidExists($conn, $username) !== false){
        echo '<script>alert("Username taken!")</script>';
        echo '<script>location.href="registeruser.php?error=usernametaken"</script>';
        exit();
    }

    createuser($conn, $name, $email, $username, $pwd);
}
else {
    
    header("location:../registeruser.php");
    exit();

}
?>