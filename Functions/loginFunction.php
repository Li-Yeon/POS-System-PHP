<?php

function emptyInputSignup($name, $email, $username, $pwd, $pwdrepeat){
    $result;
    if(empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
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

function invalidEmail($email){
    $result;
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else {
        $result = false;
    }
    return $result;
}

function pwdMatch($pwd, $pwdRepeat){
    $result;
    if($pwd !== $pwdRepeat){
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
    header("location:../registeruser.php");
    exit();
}

function emptyInputLogin($username, $pwd){
    $result;
    if (empty($username) || empty($pwd)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function startSession($conn, $username){
    $uidExists = uidExists($conn, $username);
    $_SESSION["username"] = $uidExists["Username"];
    if(isset($_SESSION['username'])){
     session_start();
     header("location:../Dashboard/Home/home.php");
     exit();
    }
    else
    {
        echo '<script>alert("You must login first!");</script>';
        echo '<script>location.href="../index.php";</script>';
        exit();
    }
}
