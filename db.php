<?php
	$DB_NAME = 'messanger';
	$DB_HOST = '127.0.0.1';
	$DB_USER = 'root';
	$DB_PASS = '';
	
	global $mysqli;
	$mysqli= mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
?>