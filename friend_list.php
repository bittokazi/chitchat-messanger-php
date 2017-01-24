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
	$sql="SELECT * FROM friend_list WHERE friend_id='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		
	}
	else {
		while($row = $result->fetch_assoc()) {
			$sql1="SELECT * FROM friend_list WHERE friend_id='".$row['username']."' AND username='".$un."'";
			$result1=$mysqli->query($sql1);
			if($result1->num_rows <= 0) {
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left; cursor:pointer;" onclick="user_profile_ss(\''.$row['username'].'\')">'.$row['username'].' - Accept</div>';
			}
			else {
				
			}
		}
	}
	
	$sql="SELECT * FROM friend_list WHERE username='".$un."'  ORDER BY friend_id";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		
	}
	else {
		while($row = $result->fetch_assoc()) {
			$sql1="SELECT * FROM friend_list WHERE username='".$row['friend_id']."' AND friend_id='".$un."'";
			$result1=$mysqli->query($sql1);
			if($result1->num_rows <= 0) {
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left; cursor:pointer;"><p>'.$row['friend_id'].' - Pending</p>';
				echo'<p>
				<button style="cursor:pointer; font-size:8px; background: none; border-radius: 3px;">Start Chat</button>&nbsp;-&nbsp;
				<button style="cursor:pointer; font-size:8px; background: none; border-radius: 3px;" onclick="user_profile_ss(\''.$row['friend_id'].'\')">User Profile</button></p></div>';
			}
			else {
				$online_stts="";
				$sql_11="SELECT * FROM friends_online WHERE username='".$row['friend_id']."'";
				$result_11=$mysqli->query($sql_11);
				if($result_11->num_rows > 0) {
					while($row_11 = $result_11->fetch_assoc()) {
						if($row_11['end']>strtotime("now")) {
							$online_stts="Online";
						}
					}
				}
				else {
					
				}
				
				
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;"><p><img src="images/';
				if($online_stts=="Online") echo 'on.png'; else  echo 'off.png';
				echo '" height="10px" width="10px" />&nbsp;'.$row['friend_id'].' - '.$online_stts.'</p>';
				$sql099="SELECT * FROM status_update WHERE username='".$row['friend_id']."' ORDER BY id DESC LIMIT 0,1";
				$result099=$mysqli->query($sql099);
				if($result099->num_rows > 0) {
					while($row099 = $result099->fetch_assoc()) {
						echo '<p>'.substr($row099['status'],0,70).' ...'.'</p>';
					}
				}
				else {

				}
				echo'<p>
				<button style="cursor:pointer; font-size:8px; background: none; border-radius: 3px;" onclick="open_private_chat(\''.$row['friend_id'].'\')">Start Chat</button>&nbsp;-&nbsp;
				<button style="cursor:pointer; font-size:8px; background: none; border-radius: 3px;" onclick="user_profile_ss(\''.$row['friend_id'].'\')">User Profile</button></p></div>';
			}
		}
	}
?>