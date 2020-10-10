<?php
session_start();
require 'database.php';
if(!isset($_SESSION['user_id'])){
    echo "You must have an account to submit a story.";
}
else{

 if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
   
//post the story to database
$user_id = $_SESSION['user_id'];
$title = $_POST['title'];
$story = $_POST['story'];
if($_POST['link']==""){
    $_POST['link']="#";
}
$link = $_POST['link'];
if($_POST['category']==""){
    $_POST['category']=null;
}
$category = $_POST['category'];

$stmt = $mysqli->prepare("insert into stories(user_id, title, story, link, category) values (?, ?, ?, ?, ?)");
if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('issss', $user_id,$title,$story,$link,$category);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
}
?>