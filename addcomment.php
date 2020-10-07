<?php
session_start();
require 'database.php';

//insert comment into database
$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'];
$comment_text = $_POST['comment_text'];

$stmt = $mysqli->prepare("insert into comments(user_id, post_id, comment_text) values (?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('iis', $user_id,$post_id,$comment_text);
$stmt->execute();
$stmt->close();

?>