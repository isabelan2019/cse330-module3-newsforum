<?php
require 'database.php';

$newuser = (string) $_POST['newuser'];
$newpassword = password_hash((string) $_POST['newpassword'], PASSWORD_DEFAULT);

//checks username doesnt already exist
$stmt = $mysqli->prepare("SELECT COUNT(*), id, hashed_password from users where username=?");

//bind parameter
$stmt->bind_param('s',$user);
$_SESSION['user'] = (string) $_POST['username'];
$user = $_SESSION['user'];
$stmt->execute();
$stmt->fetch();

if ($user=$newuser) {
    header('location:userfail.html');
}

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