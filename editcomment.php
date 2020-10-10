<?php
session_start();
require 'database.php';

//set comment id and new comment passed from input
$comment_id=$_POST['comment_id'];
$new_comment=$_POST['new_comment'];

//query failed
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//update comment in database
$stmt = $mysqli->prepare("update comments set comment_text=? where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('si', $new_comment, $comment_id);
$stmt->execute();
$stmt->close();

header('Location:story_page.php');
exit;
?>