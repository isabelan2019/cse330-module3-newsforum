<?php
session_start();
require 'database.php';
if(!isset($_SESSION['user_id'])){
    echo htmlentities("You must have an account to submit a story.");
}
else{

//token does not pass
 if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}
   
//post the story to database
$user_id = (int)$_SESSION['user_id'];
$title = (string) $_POST['title'];
$story = (string) $_POST['story'];

//filtering input
//for links
//if link is empty then fill it with #
//otherwise if link does not have http or www, does not have .com or has white space, echo invalid url 
if($_POST['link']==""){
    $_POST['link']="#";
} else if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$_POST['link'])) {
    echo htmlentities("Invalid URL"); 
    exit;
}
$link = (string)$_POST['link'];

//if the category is empty, set it to null in database
//otherwise it has to be one of the five categories we have
if($_POST['category']==""){
    $category=null;
} else if ($_POST['category']=="politics") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="science") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="arts") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="opinion") {
    $category = (string) $_POST['category'];
} else if ($_POST['category']=="sports") {
    $category = (string) $_POST['category'];
} else {
    echo htmlentities("Invalid Category Type");
    exit;
}


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