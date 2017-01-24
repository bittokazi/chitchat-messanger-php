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
$sql="SELECT * FROM room WHERE owner_id='".$un."' ORDER BY name";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			$rid=$row['id'];
			$sql1="SELECT * FROM user_online WHERE room_id='".$rid."'";
			$result1=$mysqli->query($sql1);
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left; cursor:pointer;" onclick="open_room(\''.$row['name'].'\', '.$row['id'].')">'.$row['name'].' - ('.$result1->num_rows.'/'.$row['capacity'].')</div>';
		}
	}
?>