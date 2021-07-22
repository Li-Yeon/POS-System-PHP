<?php
session_start();
if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $email = $_POST["email"];

    require_once $_SERVER['DOCUMENT_ROOT'].'/php_posv3/Database/db.php';

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


function invalidUid($username){
    $result;
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function uidExists($conn, $username){
    $sql = "SELECT * FROM users WHERE Username = ? OR Email = ?;"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location:./adduser.php?error=statementfailed");
        exit();
    }
    
    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        return $row;
    }
    else{
        $result = false;
        return $result;
    }
    mysqli_stmt_close($stmt);
}

function createuser($conn, $name, $email, $username, $pwd){
    $sql = "INSERT INTO users (Name, Email, Username, Password) values (?, ?, ?, ?);"; 
    $stmt = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location:registeruser.php?error=none");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $username, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    $_SESSION['status'] = "User successfully added!";
    $reset = "ALTER TABLE users DROP No;ALTER TABLE users AUTO_INCREMENT = 1;ALTER TABLE users ADD No int UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;";
    $resetIncrement = mysqli_multi_query($conn, $reset);
    header("location:../registeruser.php");
    exit();
}
?>