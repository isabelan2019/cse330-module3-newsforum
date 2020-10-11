<?php
session_start();
require 'database.php';

///prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$user);
$_SESSION['user'] = (string) $_POST['oldname'];
$user = $_SESSION['user'];
$stmt->execute();

//bind results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

//compare form password with database password
$pwd_guess = (string) $_POST['password'];
$correct = FALSE;

if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    //login success
    $correct =TRUE;
} else {
    //login failed 
    header('LOCATION:loginfail.html');
}

$stmt->close();

if ($correct=TRUE) {
    $changedname = (string) $_POST['changedname'];
    $stmt = $mysqli->prepare("update users set username =? where id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s \n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('si', $changedname, $user_id);
    $stmt->execute();
    $stmt->close();
    header('location:loginsuccess.html');

}




?>