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
if(isset($_GET['room_id']) && !empty($_GET['room_id'])) {
		$rid=$_GET['room_id'];
	$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0) {
	$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$un."'";
	if($mysqli->query($query)==TRUE) {
	$sql1="INSERT INTO room_message VALUES('','$rid','BOT','$un Has Left The Room!!!','text')";
	if($mysqli->query($sql1)==TRUE) {
	}
	}
	}
}
else {
	echo'Access Denied';
}
?>