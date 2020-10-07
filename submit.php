<?php
session_start();
require 'database.php';
if(!isset($_SESSION['user_id'])){
    echo "You must have an account to submit a story.";
}
else{
//post the story to database
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$story = $_POST['story'];
$link = $_POST['link'];
$tags = $_POST['tags'];

$stmt = $mysqli->prepare("insert into stories(user_id, title, story, link, tags) values (?, ?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('issss', $user_id,$title,$story,$link,$tags);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
}
?>