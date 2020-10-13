<?php
session_start();
require 'database.php';

//if unregistered user clicks
if(!isset($_SESSION['user_id'])){
    echo htmlentities("You must have an account to like.");
}

else{ 

    
    $cmtid = (int) $_POST['comment_id'];

    //gets likes
    $stmt = $mysqli->prepare("SELECT comment_likes from comments where comment_id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

   $stmt->bind_param('i', $cmtid);
   $stmt->execute();
   $stmt->bind_result($addlike);
   $stmt->fetch();
   $addlike=$addlike+1; //adds a like
   $stmt->close();

   $stmt = $mysqli->prepare("UPDATE comments set comment_likes=? where comment_id=?");
    if (!$stmt) {
        printf("Query Prep Failed: %s \n", $mysqli->error);
        exit;
    }
    
    $stmt->bind_param('ii', $addlike, $cmtid);
    $stmt->execute();
    $stmt->close();
    header('location:story_page.php');
    exit;

}

?>

