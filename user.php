<?php
session_start();
require 'database.php';

//prepared statement
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$user);
$_SESSION['user'] = (string) $_POST['username'];
$user = $_SESSION['user'];
if( !preg_match('/^[\w_\-]+$/', $user) ){
	echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
	exit;
}
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
    header('LOCATION:loginfail.html');
}

$stmt->close();

//generate token
$_SESSION['token'] = bin2hex(random_bytes(32));
?>