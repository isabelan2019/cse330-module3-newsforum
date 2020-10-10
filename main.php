<?php
    session_start();
    //check to see if the user is registered or unregistered
    //if registered, set username and user_id variables
    if(isset($_SESSION['user_id'])){
    $username= (string) $_SESSION['user'];
    $user_id = (int) $_SESSION['user_id'];
    $token=$_SESSION['token'];
    }
   
    //reset session id for post id and post title whenever redirected back to this page
    $_SESSION["post_id"]=null;
    $_SESSION["post_title"]=null;
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="file.css" type="text/css" rel="stylesheet" />
    <title>The Quarterly</title>
    <link href="news.css" type="text/css" rel="stylesheet" />
</head>

<body>
<h1>Welcome to The Quarterly</h1>
<!--navigation bar that allows user to click on a category and display posts associated with category-->
<nav>
    <form action="main.php" >
        <input type="submit" value="All">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="Sports">
        <input type="hidden" value="sports">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="Politics">
        <input type="hidden" value="politics">
    </form>
    <form action="specific_story.php" method="post">
    <input type="submit" name="category" value="Science">
        <input type="hidden" value="science">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="Opinion">
        <input type="hidden" value="opinion">
    </form>
    <form action="specific_story.php" method="post">
        <input type="submit" name="category" value="Arts">
        <input type="hidden" value="arts">
    </form>
</nav>
<?php
    require 'database.php';
    //if registered user, log out button appears
    if(isset($_SESSION['user_id'])){
        printf("<p > You are logged in as %s </p>",
        htmlspecialchars($username));

        echo "<div class='log'>
            <form action='logout.php' method='POST'>
            <input type='submit' value='Log Out'>
            </form>
            </div>";
        }
    else{
     //if unregistered user, log in button appears
        echo "<div>
        <form action='login.html' method='POST'>
            <input type='submit' value='Log In'>
        </form>
    </div>";
    }
    echo "<div>";

    //select all relevant info on every story in stories table
    $stmt = $mysqli->prepare("select title, story, link, user_id, post_id from stories");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($submission_title,$submission_story,$submission_link,$submission_user,$submission_id);

    
    while($stmt->fetch()){
        echo "<div class='story'>\n";
         
    // print out the title, story, and link for registered and unregistered users
        printf("\t<a class='title' href=%s> %s </a>",
            htmlspecialchars($submission_link),
            htmlspecialchars($submission_title)
    );    

    //have a view button to view story and comments
    echo "\t<form action='story_page.php' method='post'>
            <input type='submit' value='View'>
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='post_title' value='$submission_title'>
            </form>";    
        
    //if registered user and this post is owned by that user, then have delete and edit buttons appear
        if(isset($_SESSION['user_id']) && $_SESSION['user_id']==$submission_user){
           //delete post
            echo "<form action='deletestory.php' method='POST'> 
            <input type='submit' value='Delete Post'> 
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='token' value='$token'>
            </form>";
            
           //edit post
            echo "<form action='editstory_page.php' method='POST'> 
            <input type='submit' value='Edit Post'> 
            <input type='hidden' name='post_id' value=$submission_id>
            <input type='hidden' name='token' value='$token'>
            </form>";
            
        }     
        echo "</div>\n";
    }
    $stmt->close();
?>
</div>
<div>
    <form action="submit_page.php" method="post">
        <input id="submit" type="submit" value="Submit Your Story">
    </form>
</div>


</body>

</html>