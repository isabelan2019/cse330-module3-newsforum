<?php
session_start();
require 'database.php';



//prepared statement --checks user credentials
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

//checks username with cnt and password with pwd
if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    //login success
    $correct = TRUE;
} else {
    //login failed 
    header('LOCATION:loginfail.html');
}
$stmt->close();

//prepared statement --checks user credentials
$stmt = $mysqli->prepare("SELECT COUNT(*) from users where username=?");

//bind parameter
$stmt->bind_param('s',$newuser);
$_SESSION['newuser'] = (string) $_POST['changedname'];
$newuser = $_SESSION['newuser'];
$stmt->execute();

//bind results
$stmt->bind_result($newcnt);
$stmt->fetch();
//if username already exists
if ($newcnt > 0) {
    header('location:userfail.html');
    exit;
}
$stmt->close();

if ($correct==TRUE) {
    $changedname = (string) $_POST['changedname'];
    if( !preg_match('/^[\w_\-]+$/', $changedname) ){
        echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
        exit;
    }
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