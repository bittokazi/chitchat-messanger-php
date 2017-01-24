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

	$sql="SELECT * FROM room_message WHERE from_user='".$un."' ORDER BY id DESC";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		$recent=array(); $recent_id=array(); $recent_cap=array(); $recent_i=0;
		while($row = $result->fetch_assoc()) {
			if($recent_i==0) {
				$sql1="SELECT * FROM room WHERE id='".$row['room_id']."'";
				$result1=$mysqli->query($sql1);
				while($row1 = $result1->fetch_assoc()) {
					$recent[$recent_i]=$row1['name'];
					$recent_cap[$recent_i]=$row1['capacity'];
				}
				$recent_id[$recent_i]=$row['room_id'];
				$recent_i++;
			}
			else {
				$match=0;
				for($i=0; $i<$recent_i; $i++) {
					if($recent_id[$i]==$row['room_id']) {
						$match=1;
						break;
					}
				}
				if($match==0) {
					$sql1="SELECT * FROM room WHERE id='".$row['room_id']."'";
					$result1=$mysqli->query($sql1);
					while($row1 = $result1->fetch_assoc()) {
						$recent[$recent_i]=$row1['name'];
						$recent_cap[$recent_i]=$row1['capacity'];
					}
					$recent_id[$recent_i]=$row['room_id'];
					$recent_i++;
				}
			}
			if($recent_i>=10) {
				break;
			}
		}
		for($i=0; $i<$recent_i; $i++) {
			$rid=$recent_id[$i];
			$sql3="SELECT * FROM user_online WHERE room_id='".$rid."'";
			$result3=$mysqli->query($sql3);
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left; cursor:pointer;" onclick="open_room(\''.$recent[$i].'\', '.$recent_id[$i].')">'.$recent[$i].' - ('.$result3->num_rows.'/'.$recent_cap[$i].')</div>';
		}
	}
?>