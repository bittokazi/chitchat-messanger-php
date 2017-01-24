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
if(isset($_POST['stts']) && !empty($_POST['stts'])) {
	$rtext=$_POST['stts'];
	$sql="INSERT INTO status_update VALUES('','$un','$rtext')";
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