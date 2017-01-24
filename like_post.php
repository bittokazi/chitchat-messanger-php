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
if(isset($_GET['uid']) && !empty($_GET['uid'])) {
	$uid=$_GET['uid'];
	$sql_l="SELECT * FROM like_list WHERE post_id='".$uid."' AND username='".$un."'";
		$result_l=$mysqli->query($sql_l);
			if($result_l->num_rows > 0) {
				$query="DELETE FROM like_list WHERE post_id='".$uid."' AND username='".$un."'";
				$mysqli->query($query);
				echo 'ok';
			}
			else {
				$query="INSERT INTO like_list VALUES('','$uid','$un')";
				$mysqli->query($query);
				echo 'ok';
			}
}
else {
	
}
?>