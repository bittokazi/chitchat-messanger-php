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
if(isset($_POST['crnm']) && !empty($_POST['crnm']) && isset($_POST['crds']) && !empty($_POST['crds'])) {
	$crnm=$_POST['crnm'];
	$crds=$_POST['crds'];
	$sql="SELECT * FROM room WHERE name='".$crnm."'";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0) {
		echo 'exist';
		exit;
	}
	else {
		$sql="INSERT INTO room VALUES('','$crnm','$crds','25','$un')";
			if($mysqli->query($sql)==TRUE) {
			echo'ok';
			}
			else {
			echo'error';
			}
	}
}
else {
	echo 'empty';
	exit;
}
?>