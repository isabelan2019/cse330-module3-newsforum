<?php
//LOGS OUT the user when this php script is called
session_start();
session_destroy();
header("Location:login.html");
?>