<?php
session_start();
require 'database.php';

$newuser = (string) $_POST['newuser'];
if( !preg_match('/^[\w_\-]+$/', $newuser) ){
	echo "Invalid username. You can only use alphanumeric characters, hyphens, and underscores.";
	exit;
}
$newpassword = password_hash((string) $_POST['newpassword'], PASSWORD_DEFAULT);

//checks username doesnt already exist
$stmt = $mysqli->prepare("SELECT COUNT(*) from users where username=?");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
    exit;
}

//bind parameter
$stmt->bind_param('s', $user);
$_SESSION['user'] = (string) $_POST['newuser'];
$user = $_SESSION['user'];
$stmt->execute();

//bind results
$stmt->bind_result($cnt);
$stmt->fetch();

//if username already exists
if ($cnt>0) {
    header('location:userfail.html');
    exit;
}
$stmt->close();



$stmt = $mysqli->prepare("insert into users (username, hashed_password) values (?,?)");
if (!$stmt) {
    printf("Query Prep Failed: %s \n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss', $newuser, $newpassword);
$stmt->execute();
$stmt->close();
header('location:loginsuccess.html');
?>