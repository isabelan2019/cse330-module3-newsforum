<?php
session_start();
require 'database.php';

//delete story from database
$post_id=$_POST['post_id'];
echo $post_id;

$stmt = $mysqli->prepare("delete from stories where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('i', $post_id);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
?>