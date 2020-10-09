<?php
session_start();
require 'database.php';

//set post id from hidden input 
$post_id=$_POST['post_id'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//first delete all comments associated with the post 
$stmt = $mysqli->prepare("delete from comments where post_id=?");

//query failed
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();

//then delete the post
$stmt = $mysqli->prepare("delete from stories where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();

//redirect to main page after success
header('Location:main.php');
exit;
?>