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

if(isset($_GET['rid']) && $_GET['rid']!='') {
	$room_full=0;
	$rid=$_GET['rid'];
	$sql="SELECT * FROM room WHERE id='".$rid."'";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$sql0="SELECT * FROM user_online WHERE room_id='".$rid."'";
			$result0=$mysqli->query($sql0);
			$sql1="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$un."'";
			$result1=$mysqli->query($sql1);
			if($result0->num_rows >= $row['capacity'] && $result1->num_rows<1) {
				echo 'Room Full - you can wait. you will logged in whenever room vacates.';
				$room_full=1;
			}
			else {

			}
		}
	}
	else {
		echo 'Error';
		exit;
	}
	
	if($room_full==1) {
		
	
	$sql="SELECT * FROM user_online WHERE room_id='".$rid."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			if($row['end']<strtotime("now")) {
				$user=$row['username'];
				$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$user."'";
				$mysqli->query($query);
				$sql1="INSERT INTO room_message VALUES('','$rid','BOT','$user Has Left The Room!!!','text')";
				if($mysqli->query($sql1)==TRUE) {
					$room_full=0;
					break;
				}
			}
		}
	}
	
		
	}
	if($room_full==0) {
		$sql1="SELECT * FROM kick_list WHERE room_id='".$rid."' AND username='".$un."'";
		$result1=$mysqli->query($sql1);
		if($result1->num_rows > 0) {
			while($row = $result1->fetch_assoc()) {
			if($row['start']>strtotime("now")) {
				echo 'you have been kicked from room please try again later';
				exit;
			}
			else {
				$query="DELETE FROM kick_list WHERE room_id='".$rid."' AND username='".$un."'";
				$mysqli->query($query);
			}
			}
		}
		else {
			$sql1="SELECT * FROM banned_list WHERE type='room' AND from_id='".$rid."' AND username='".$un."'";
			$result1=$mysqli->query($sql1);
					if($result1->num_rows > 0) {
						echo '0:BOT : you are banned from this room<br>';
						exit;
					}
		}
	} else { exit; }
	
	
	$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		$currenttime=strtotime("now");
		$endtime=$currenttime+300;
		$sql="INSERT INTO user_online VALUES('$un','$rid','$currenttime','$endtime')";
			if($mysqli->query($sql)==TRUE) {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','$un Has Entered The Room!!!','text')";
				if($mysqli->query($sql)==TRUE) {
					$room_full=0;
				}
			}
	}
	else {
		$currenttime=strtotime("now");
		$endtime=$currenttime+300;
		$query="UPDATE user_online SET start = '".$currenttime."'  
				WHERE room_id='".$rid."' AND username='".$un."'";
		$mysqli->query($query);
		$query="UPDATE user_online SET end = '".$endtime."'  
				WHERE room_id='".$rid."' AND username='".$un."'";
		$mysqli->query($query);
	}
	$sql="SELECT * FROM user_online WHERE room_id='".$rid."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			if($row['end']<strtotime("now")) {
				$user=$row['username'];
				$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$user."'";
				$mysqli->query($query);
				$sql1="INSERT INTO room_message VALUES('','$rid','BOT','$user Has Left The Room!!!','text')";
				if($mysqli->query($sql1)==TRUE) {
			
				}
			}
		}
	}
	$sql="SELECT * FROM user_online WHERE room_id='".$rid."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		$i=1;
		while($row = $result->fetch_assoc()) {
			$sql0="SELECT * FROM room WHERE owner_id='".$row['username']."' AND id='".$rid."'";
			$result0=$mysqli->query($sql0);
			$sql8="SELECT * FROM moderator_list WHERE username='".$row['username']."' AND room_id='".$rid."'";
			$result8=$mysqli->query($sql8);
			if($result0->num_rows > 0) {
				echo $i.'. '.$row['username'].'(O)<br>';
			}
			else if($result8->num_rows > 0) {
				echo $i.'. '.$row['username'].'(M)<br>';
			}
			else {
				echo $i.'. '.$row['username'].'<br>';
			}
			$i++;
		}
	}
}
else {
	echo 'no';
	exit;
}
?>