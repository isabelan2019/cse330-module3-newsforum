<?php
require 'database.php';

$username = $_POST['newuser'];
$password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT);
//use password_hash($password , PASSWORD_DEFAULT);


$stmt = $mysqli->prepare("insert into users(username, hashed_password) values(?,?)");
if (!$stmt) {
    printf("Query Prep Failed: %s \n", $mysqli->error);
    exit;
}

$stmt->bind_param('ss',$username, $password);
$stmt->execute;
$stmt->close;

?>