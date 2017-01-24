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
if(isset($_GET['room_id']) && !empty($_GET['room_id'])) {
	$room_id=$_GET['room_id'];
	$sql4="SELECT * FROM room WHERE id='".$room_id."'";
	$result4=$mysqli->query($sql4);
	if($result4->num_rows > 0) {
		while($row4 = $result4->fetch_assoc()) {
			$sql0="SELECT * FROM user_online WHERE room_id='".$room_id."'";
			$result0=$mysqli->query($sql0);
			$sql1="SELECT * FROM user_online WHERE room_id='".$room_id."' AND username='".$un."'";
			$result1=$mysqli->query($sql1);
			if($result0->num_rows >= $row4['capacity'] && $result1->num_rows<1) {
				echo 'Room Full';
				exit;
			}
			else {
				$sql1="SELECT * FROM kick_list WHERE room_id='".$room_id."' AND username='".$un."'";
				$result1=$mysqli->query($sql1);
				if($result1->num_rows > 0) {
					while($row = $result1->fetch_assoc()) {
						if($row['start']>strtotime("now")) {
							echo '0:BOT : you have been kicked from room please try again later<br>';
							exit;
						}
						else {
							$query="DELETE FROM kick_list WHERE room_id='".$room_id."' AND username='".$un."'";
							$mysqli->query($query);
						}
					}
				}
				else {
					$sql1="SELECT * FROM banned_list WHERE type='room' AND from_id='".$room_id."' AND username='".$un."'";
					$result1=$mysqli->query($sql1);
					if($result1->num_rows > 0) {
						echo '0:BOT : you are banned from this room<br>';
						exit;
					}
				}
			}
		}
	}
	else {
		echo 'Error';
		exit;
	}
	$cht=array(); $cht_i=0;
	$sql="SELECT * FROM room_message WHERE room_id='".$room_id."' ORDER BY id DESC LIMIT 0,40";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'No Chats to Display';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			if($row['type']=="image") { $cht[$cht_i]=$row['id'].':'.$row['from_user'].' : <img src="shared-photo/'.$row['message'].'" height="100px" width="100px"/><br>';  }
			else { $cht[$cht_i]=$row['id'].':'.$row['from_user'].' : '.$row['message'].'<br>'; }
			$cht_i++;
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