<?php
session_start();
require 'database.php';

//if unregistered user tries to click on add comment button, give error message
if(!isset($_SESSION['user_id'])){
    echo "You must have an account to comment.";
}

else{

//query failed
if(!hash_equals($_SESSION['token'], $_POST['token'])){
    die("Request forgery detected");
}

//if registered user, insert comment into database
$user_id = $_SESSION['user_id'];
$post_id = $_SESSION['post_id'];
$comment_text =  (string) $_POST['comment_text'];

$stmt = $mysqli->prepare("insert into comments(user_id, post_id, comment_text) values (?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('iis', $user_id,$post_id,$comment_text);
$stmt->execute();
$stmt->close();

header('location:story_page.php');
exit;
}


?>