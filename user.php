<?php
session_start();
require 'database.php';

//prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$user);
$_SESSION['user'] = (string) $_POST['username'];
$user = $_SESSION['user'];
$stmt->execute();

//bind results
$stmt->bind_result($cnt, $user_id, $pwd_hash);
$stmt->fetch();

//compare form password with database password
$pwd_guess = (string) $_POST['password'];

if($cnt==1 && password_verify($pwd_guess, $pwd_hash)){
    //login success
    $_SESSION['user_id'] = $user_id;
    //redirect to target page
    header('LOCATION:main.php');
} else {
    //login failed 
    header('LOCATION:loginfail.php');
}

//retrieve associated user_id and set session variable
$stmt = $mysqli->prepare("select id from users where username=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('s',$user);
$stmt->execute();
$stmt->bind_results($user_id);

while($stmt->fetch()){
    $_SESSION['user_id'] = $user_id;
}
$stmt->close();
?>