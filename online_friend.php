<?php
session_start();
if(!isset($_SESSION['login_user'])) {
	header('Location: login.php');
	exit;
}
else {
	include('db.php');
	$un=$_SESSION['login_user'];
}


	$sql="SELECT * FROM friends_online WHERE username='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		$currenttime=strtotime("now");
		$endtime=$currenttime+300;
		$sql="INSERT INTO friends_online VALUES('$un','$currenttime','$endtime')";
			if($mysqli->query($sql)==TRUE) {
				
			}
	}
	else {
		$currenttime=strtotime("now");
		$endtime=$currenttime+300;
		$query="UPDATE friends_online SET start = '".$currenttime."'  
				WHERE username='".$un."'";
		$mysqli->query($query);
		$query="UPDATE friends_online SET end = '".$endtime."'  
				WHERE username='".$un."'";
		$mysqli->query($query);
	}	
?>