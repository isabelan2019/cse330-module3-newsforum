<?php
require 'database.php';

//prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$user);
$user = $_POST['username'];
$stmt->execute();

//bind results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

//compare form password with database password
$pwd_guess = $_POST['password'];

if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    //login success
    $_SESSION['user_id'] = $user_id;
    //redirect to target page
    header('LOCATION:main.php');
} else {
    //login failed 
    header('LOCATION:loginfail.html');
}

?>