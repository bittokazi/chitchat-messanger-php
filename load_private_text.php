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
if(isset($_GET['user_id']) && !empty($_GET['user_id'])) {
	$user_id=$_GET['user_id'];
	$cht=array(); $cht_i=0;
	$sql="SELECT * FROM user_message WHERE inbox_id='".$un.">>--<<".$user_id."' ORDER BY id DESC LIMIT 0,40";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'No Chats to Display';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			if($row['type']=="image") {
				$cht[$cht_i]=$row['from_user'].' : <img src="shared-photo/'.$row['message'].'" height="100px" width="100px"/><br>';
			}
			else {
				$cht[$cht_i]=$row['from_user'].' : '.$row['message'].'<br>';
			}
			$cht_i++;
			if($row['status']=="1") {
			$query="UPDATE user_message SET status = '0' WHERE id='".$row['id']."'";
			$mysqli->query($query);
			}
		}
	}
	while($cht_i>0) {
		echo $cht[$cht_i-1];
		$cht_i--;
	}
}
else {
	echo 'no';
}
?>