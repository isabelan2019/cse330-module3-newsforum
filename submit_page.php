<?php
session_start();
if(!isset($_SESSION['user_id'])){
    echo "You must have an account to submit a story.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Story</title>
    <link href="news.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <h2> Submit your story below by filling out the fields. You can also choose to sort your post in one of the following categories: politics, science, arts, sports, opinion. </h2>
    <form action="submit.php" method="post">
        <label> Submission Title: </label>
        <input type="text" name="title" required>
        <label> Submission Text: </label>
        <textarea name="story" required> </textarea>
        <label> Link (optional): </label>
        <input type="text" name="link">
        <label> Category (optional): </label>
        <input type="text" name="category">
        <input type="submit" value="Post Your Story">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
</body>
</html>