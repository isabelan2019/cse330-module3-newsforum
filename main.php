<?php
    session_start();
    $username= (string) $_SESSION['user'];
    $user_id = (int) $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="file.css" type="text/css" rel="stylesheet" />
    <title>The Quarterly</title>
</head>

<body>
<h1>Welcome to the Quarterly</h1>
<div id="login">
    <form action="login.html" method="POST">
        <input type="submit" value="Log In">
    </form>
</div>
<?php
    require 'database.php';
    $stmt = $mysqli->prepare("select title, story, link, user_id, post_id from stories");
    if(!$stmt){
        printf("Query Prep Failed: %s\n", $mysqli->error);
        exit;
    }
    $stmt->execute();
    $stmt->bind_result($submission_title,$submission_story,$submission_link,$submission_user,$submission_id);

   
    while($stmt->fetch()){
        echo "<div>\n";
        printf("\t<a href=%s> %s </a> %s %u",
            htmlspecialchars($submission_link),
            htmlspecialchars($submission_title),
            htmlspecialchars($submission_story),
            htmlspecialchars($submission_id)
    );
        printf("\t<form action='story_page.php' method='post'>
                <input type='hidden' name='post_id' value=%u>
                <input type='submit' value='Comments'>
                </form>",
                $submission_id
          );
        if($_SESSION['user_id']==$submission_user){
            echo "<form action='deletestory.php' method='POST'> 
            <input type='submit' value='Delete Post'> 
            <input type='hidden' name='post_id' value=$submission_id>
            </form>";
        }     
        echo "</div>\n";
    }
    $stmt->close();
?>
<div>
    <a href="submit.html"> Submit Your Story </a>
</div>
<div id="logout">
    <form action="logout.php" method="POST">
        <input type="submit" value="Log Out">
    </form>
</div>

</body>

</html>