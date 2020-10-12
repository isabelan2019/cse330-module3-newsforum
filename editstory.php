<?php
session_start();
require 'database.php';

//set variables
$post_id=(int)$_SESSION['post_id'];
$new_title = (string)$_POST['title'];
$new_story = (string)$_POST['story'];

//filtering input
//for links
//if link is empty then fill it with #
//otherwise if link does not have http or www or has white space, echo invalid url 
if($_POST['link']==""){
    $_POST['link']="#";
} else if (!preg_match('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i',$_POST['link'])) {
    echo "Invalid URL"; 
    exit;
}
$new_link = $_POST['link'];


//if the category is empty, set it to null in database
//otherwise it has to be one of the five categories we have
if($_POST['category']==""){
    $new_category=null;
} else if ($_POST['category']=="politics") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="science") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="arts") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="opinion") {
    $new_category = (string) $_POST['category'];
} else if ($_POST['category']=="sports") {
    $new_category = (string) $_POST['category'];
} else {
    echo "Invalid Category Type";
    exit;
}

//token does not pass
if(!hash_equals($_SESSION['token'], $_POST['token'])){
	die("Request forgery detected");
}

//update story in stories table using post id
$stmt = $mysqli->prepare("update stories set title=?, story=?, link=?, category=? where post_id=?");

if(!$stmt){
    printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}

$stmt->bind_param('ssssi', $new_title, $new_story, $new_link, $new_category, $post_id);
$stmt->execute();
$stmt->close();

header('Location:main.php');
exit;
?>