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
	$sql="DELETE FROM friend_list WHERE username='$un' AND friend_id='$rid'";
	$mysqli->query($sql);
	$sql="DELETE FROM friend_list WHERE username='$rid' AND friend_id='$un'";
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