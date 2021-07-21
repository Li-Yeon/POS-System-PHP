<?php

session_start();

if (isset($_POST['Login'])){
    $username = $_POST["username"];
    $pwd = $_POST["password"];
    $_SESSION['currentUser'] = $username;

    require_once '../Database/db.php';
    
    loginUser($conn, $username, $pwd);
}
else{
    header("location:../index.php");
    exit();
}

function loginUser($conn, $username, $pwd){
    $uidExists = uidExists($conn, $username, $username);

    if($uidExists === false){
        header("location:../index.php?error=wronglogin");
        exit();
    }
    
    $pwdHashed = $uidExists["Password"];
    $checkPwd = password_verify($pwd , $pwdHashed);

    if($checkPwd === false){
        header("location:../index.php?error=wronglogin");
        exit();
    }
    else if($checkPwd === true){
            session_start();            
            header("location:../dashboard.php");
    }
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


