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
	$sql="SELECT * FROM user_profile WHERE username LIKE'%".$rid."%'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left; cursor:pointer;" onclick="user_profile_ss(\''.$row['username'].'\')">'.$row['username'].'</div>';
		}
	}
}
else {
	echo 'no';
	exit;
}
?>