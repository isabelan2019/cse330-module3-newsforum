<?php
session_start();
require 'database.php';

//input passed from main page when comments button is clicked 
//set session id variable for the post
if(isset($_SESSION['user_id'])){
    $token=$_SESSION['token'];
}
if(!isset($_SESSION['post_id'])){
    $_SESSION['post_id']=(int)$_POST['post_id'];
    
}
$post_id=$_SESSION['post_id'];


if(!isset($_SESSION['post_title'])){
    $_SESSION['post_title'] = (string)$_POST['post_title'];
}
$post_title=$_SESSION['post_title'];

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo htmlspecialchars($post_title)?> </title>
</head>
<body>
    <?php
        //retrieve the original post using the post id
        $stmt=$mysqli->prepare("select title, story, link, user_id from stories where post_id=?");
        if(!$stmt){
            printf("Query Prep Failed: %s\n", $mysqli->error);
            exit;
        }

        $stmt->bind_param('i',$post_id);
        $stmt->execute();
        $stmt->bind_result($title,$story,$link,$user_id);

        //print out the title and story of the post 
        while($stmt->fetch()){
            printf("%s %s %u",
                htmlspecialchars($title),
                htmlspecialchars($story),
                htmlspecialchars($user_id)
            );

        //if registered user, they will see a textbox and add comment button
            if(isset($_SESSION['user_id'])){
            echo "<form action='addcomment.php' method='post'>
                <textarea name='comment_text'> </textarea>
                <input type='hidden' name='post_id' value=$post_id>
                <input type='submit' value='Add Comment'>
                <input type='hidden' name='token' value='$token'>
                </form>";
            }
        }

        //retrieve all comments associated with that post
        $stmt = $mysqli->prepare("select comment_text, users.username, comment_id,user_id, post_id from comments join users on (users.id=user_id) where post_id=?");
            if(!$stmt){
                printf("Query Prep Failed: %s\n", $mysqli->error);
                exit;
            }

            $stmt->bind_param('i',$post_id);
            $stmt->execute();
            $stmt->bind_result($comment_text,$username,$comment_id,$user_id, $post_id);

        //display all comments below post
            while($stmt->fetch()){
                echo "<div>\n";
                printf("\t %s %s %u" ,
                    htmlspecialchars($username),
                    htmlspecialchars($comment_text),
                    htmlspecialchars($comment_id)
            );
        //if registered user and comment belongs to registered user, buttons will appear to delete and edit comment 
                if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$user_id){
                echo "<form action='editcomment.php' method='POST'> 
                    <input type='submit' value='Edit'> 
                    <textarea name='new_comment'> </textarea>
                    <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    <input type='hidden' name='token' value='$token'>
                    </form>";
                echo "<form action='deletecomment.php' method='POST'> 
                    <input type='submit' value='Delete'> 
                    <input type='hidden' name='comment_id' value=$comment_id>
                    <input type='hidden' name='user_id' value=$post_id>
                    <input type='hidden' name='token' value='$token'>
                    </form>";
                echo "</div>\n";
                }
            }
            $stmt->close();

    ?>
    <form action="returnmain.php" method="post">
        <input type="submit" value="Return to Main Page">
    </form>
</body>
</html>