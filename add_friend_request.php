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
if(isset($_GET['rid']) && !empty($_GET['rid'])) {
	$rid=$_GET['rid'];
	$sql="INSERT INTO friend_list VALUES('','$un','$rid')";
	if($mysqli->query($sql)==TRUE) {
		echo'ok';
	}
	else {
		echo'no';
	}
}
else {
	echo 'no';
	exit;
}
?>