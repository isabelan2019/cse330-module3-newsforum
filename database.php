<?php

$mysqli = new mysqli('localhost', 'username', 'password', 'databasename');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>