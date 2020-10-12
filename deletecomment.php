<?php
session_start();
require 'database.php';

//set the comment id from input
$comment_id=(int)$_POST['comment_id'];

//token does not pass
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
//delete comment from database
$stmt = $mysqli->prepare("delete from comments where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $comment_id);
$stmt->execute();
$stmt->close();

header('location:story_page.php');
exit;
?>