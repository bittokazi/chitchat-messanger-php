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
if(isset($_GET['rid']) && !empty($_GET['rid']) && isset($_POST['rtext']) && !empty($_POST['rtext'])) {
	$rid=$_GET['rid'];
	$rtext=$_POST['rtext'];
	$sql="INSERT INTO user_message VALUES('','$un>>--<<$rid','$un','$rid','$rtext','text','0')";
	$mysqli->query($sql);
	$sql="INSERT INTO user_message VALUES('','$rid>>--<<$un','$un','$rid','$rtext','text','1')";
	if($mysqli->query($sql)==TRUE) {
		echo'ok';
	}
	else {
		echo'error';
	}
}
else {
	echo 'empty';
	exit;
}
?>