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
if(isset($_GET['uid']) && !empty($_GET['uid']) && isset($_POST['rtext']) && !empty($_POST['rtext'])) {
	$uid=$_GET['uid'];
	$rtext=$_POST['rtext'];
	$query="INSERT INTO comment_list VALUES('','$un','$uid','$rtext')";
				$mysqli->query($query);
				echo 'ok';
}
else {
	
}
?>