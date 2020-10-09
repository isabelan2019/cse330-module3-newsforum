<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Story</title>
</head>
<body>
    <form action="submit.php" method="post">
        <label> Submission Title: </label>
        <input type="text" name="title">
        <label> Submission Text: </label>
        <textarea name="story"> </textarea>
        <label> Link (optional): </label>
        <input type="text" name="link">
        <label> Tags (optional): </label>
        <input type="text" name="tags">
        <input type="submit" value="Post Your Story">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
    </form>
</body>
</html>