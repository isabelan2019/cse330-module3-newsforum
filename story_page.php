<?php
session_start();
require 'database.php';
$post_id=$_POST['post_id'];

//retrieve the original post
$stmt=$mysqli->prepare("select title, story, link, user_id from stories where post_id=?");
if(!$stmt){
	printf("Query Prep Failed: %s\n", $mysqli->error);
	exit;
}
$stmt->bind_param('i',$post_id);
$stmt->execute();
$stmt->bind_result($title,$story,$link,$user_id);
while($stmt->fetch()){
    printf("%s %s %u",
        htmlspecialchars($title),
        htmlspecialchars($story),
        htmlspecialchars($user_id)
    );

    echo "<form action='addcomment.php' method='post'>
        <textarea name='comment_text'> </textarea>
        <input type='hidden' name='post_id' value=$post_id>
        <input type='submit' value='Add Comment'>";
    
}

//show all comments
$stmt = $mysqli->prepare("select comment_text, users.username, comment_id,user_id from comments join users on (users.id=user_id) where post_id=?");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }

    $stmt->bind_param('i',$post_id);
    $stmt->execute();
    $stmt->bind_result($comment_text,$username,$comment_id,$user_id);

   
    while($stmt->fetch()){
        echo "<div>\n";
        printf("\t %s %s",
            htmlspecialchars($username),
            htmlspecialchars($comment_text)
    );
        if($_SESSION['user_id']==$user_id){
        echo "<form action='editcomment.php' method='POST'> 
            <input type='submit' value='Edit'> 
            <input type='hidden' name='comment_id' value=$comment_id;
            </form>";
        echo "<form action='deletecomment.php' method='POST'> 
            <input type='submit' value='Delete'> 
            <input type='hidden' name='comment_id' value=$comment_id;
            </form>";
        echo "</div>\n";
        }
    }
    $stmt->close();
?>
