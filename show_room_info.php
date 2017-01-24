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
if(isset($_GET['uid']) && !empty($_GET['uid']) && isset($_GET['divd']) && !empty($_GET['divd'])) {
	$uid=$_GET['uid'];
	$did=$_GET['divd'];
	$sql="SELECT * FROM room WHERE id='".$uid."' ORDER BY id DESC LIMIT 0,1";
		$result=$mysqli->query($sql);
		if($result->num_rows > 0) {
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_room('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Chat
			</button>
			</div>';
			while($row = $result->fetch_assoc()) {
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Room Name: '.$row['name'].'</div>';
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Room Administrator: '.$row['owner_id'].'</div>';
				echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Room Description: '.$row['description'].'</div>';
			}
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">';
			echo '<h5>Room Commands: </h5>';
			echo 'All the commands will be sent through chat<br>';
			echo '<h6>To kick a user write: k>username<br>';
			echo 'To make Moderator write: m>username<br>';
			echo 'To DeMod a Moderator write: dm>username<br>';
			echo 'To Ban a user write: b>username<br>';
			echo 'To UnBan a user write: ub>username<br></h6>';
			echo'</div>';
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">';
			echo '<h2>Moderator list: </h2>';
			$sql1="SELECT * FROM moderator_list WHERE room_id='".$uid."' ORDER BY id DESC";
			$result1=$mysqli->query($sql1);
			if($result1->num_rows > 0) {
				while($row1 = $result1->fetch_assoc()) {
					echo $row1['username'].'<br>';
				}
			}
			echo'</div>';
		}
}
else {
	
}
?>