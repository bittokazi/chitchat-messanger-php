<?php
//01920441714
session_start();
if(!isset($_SESSION['login_user'])) {
	header('Location: login.php');
	exit;
}
else {
	include('db.php');
	$un=$_SESSION['login_user'];
}
	
	$sql="SELECT * FROM friend_list WHERE username='".$un."'  ORDER BY friend_id";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		
	}
	else {
		$on="";
		while($row = $result->fetch_assoc()) {
			$sql1="SELECT * FROM friend_list WHERE username='".$row['friend_id']."' AND friend_id='".$un."'";
			$result1=$mysqli->query($sql1);
			if($result1->num_rows <= 0) {
				
			}
			else {
				$sql21="SELECT * FROM user_message WHERE inbox_id='".$un.">>--<<".$row['friend_id']."' AND status='1' ORDER BY id DESC LIMIT 0,1";
				$result21=$mysqli->query($sql21);
				if($result21->num_rows > 0) {
					echo $row['friend_id']."++--++";
				}
			}
		}
		
	}
?>