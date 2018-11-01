<?php
	$DB_NAME = $_ENV["MYSQL_DB"];
	$DB_HOST = $_ENV["MYSQL_HOST"].':'.$_ENV["MYSQL_PORT"];
	$DB_USER = $_ENV["MYSQL_UN"];
	$DB_PASS = $_ENV["MYSQL_PW"];
	
	global $mysqli;
	$mysqli= mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
	
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
?>
