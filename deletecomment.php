<?php
session_start();
require 'database.php';

//delete story from database
$comment_id=$_POST['comment_id'];
echo $comment_id;

$stmt = $mysqli->prepare("delete from comments where comment_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $comment_id);
$stmt->execute();
$stmt->close();
?>