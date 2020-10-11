<?php
session_start();
$_SESSION['post_id']=(int)$_POST['post_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Your Post </title>
    <link href="news.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <h2>This form will update all inputs for your story. For example, leaving the link input blank where you 
        used to have a link will remove the link from your story. You must re-type the values of story you want to keep.</h2>
    <form action="editstory.php" method="POST">
        <label> New Submission Title: </label>
        <input type="text" name="title" required>
        <label> New Submission Text: </label>
        <textarea name="story" required> </textarea>
        <label> New Link (optional): </label>
        <input type="text" name="link">
        <label> New Category (optional): </label>
        <input type="text" name="category">
        <input type="submit" value="Edit Your Story">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
</body>
</html>