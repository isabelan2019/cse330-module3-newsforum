<?php

$mysqli = new mysqli('localhost', 'module3', 'isabelandclaire', 'news_site');

if($mysqli->connect_errno) {
	printf("Connection Failed: %s\n", $mysqli->connect_error);
	exit;
}
?>