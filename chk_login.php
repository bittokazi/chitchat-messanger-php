<?php
session_start();
if(isset($_SESSION['login_user'])) {
	header('Location: main.php');
	exit;
}
else {
	include('db.php');
	if(isset($_GET['un']) && !empty($_GET['un']) && isset($_GET['pw']) && !empty($_GET['pw'])) {
		$un=$_GET['un'];
		$pw=md5($_GET['pw']);
		$sql="SELECT * FROM user_profile WHERE username='".$un."' AND password='".$pw."'";
		$result=$mysqli->query($sql);
		if($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				$_SESSION['login_user']=$row['username'];
				echo 'yes';
				exit;
			}
		}
		else {
			echo 'no';
			exit;
		}
	}
	else {
		echo 'empty';
		exit;
	}
}
?>