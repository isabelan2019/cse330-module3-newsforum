<?php
session_start();
require 'database.php';

//set variables
$post_id=$_SESSION['post_id'];
$new_title = $_POST['title'];
$new_story = $_POST['story'];
$new_link = $_POST['link'];
$new_tags = $_POST['tags'];

if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//update story
$stmt = $mysqli->prepare("update stories set title=?, story=?, link=?, tags=? where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssssi', $new_title, $new_story, $new_link, $new_tags, $post_id);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
?>