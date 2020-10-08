<?php
require 'database.php';

$newuser = (string) $_POST['newuser'];
$newpassword = password_hash((string) $_POST['newpassword'], PASSWORD_DEFAULT);
//use password_hash($password , PASSWORD_DEFAULT);


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