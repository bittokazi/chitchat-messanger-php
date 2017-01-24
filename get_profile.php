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
if(isset($_GET['rid']) && !empty($_GET['rid']) && isset($_GET['divd']) && !empty($_GET['divd'])) {
	$rid=$_GET['rid'];
	$did=$_GET['divd'];
	$sql="SELECT * FROM user_profile WHERE username='".$rid."'";
	$result=$mysqli->query($sql);
	if($result->num_rows <= 0) {
		echo 'no';
		exit;
	}
	else {
		while($row = $result->fetch_assoc()) {
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;"><img src="uploads/pp_'.$row['photo'].'?id='.rand(-100000,100000).'" height="200px" width="200px" /></div>';
			echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Username: '.$row['username'].'</div>';
			$sql1="SELECT * FROM friend_list WHERE username='".$rid."' AND friend_id='".$un."'";
			$result1=$mysqli->query($sql1);
			if($rid==$un) {
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Full name: '.$row['name'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Email: '.$row['email'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Cell: Hidden</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Date of Birth: '.$row['dob'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Address: '.$row['address'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">
					<button onclick="user_post_list(\''.$rid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
					My Post
					</button>
					</div>';
			}
			else if($result1->num_rows > 0) {
				$sql1="SELECT * FROM friend_list WHERE friend_id='".$rid."' AND username='".$un."'";
				$result1=$mysqli->query($sql1);
				if($result1->num_rows <= 0) {
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">
					<button onclick="add_friend_request(\''.$rid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
					Accept Friend Request
					</button>
					</div>';
				}
				else {
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Full name: '.$row['name'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Email: '.$row['email'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Cell: Hidden</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Date of Birth: '.$row['dob'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Address: '.$row['address'].'</div>';
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">
					<button onclick="delete_friend_request(\''.$rid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
					Delete Friend
					</button>
					<button onclick="user_post_list(\''.$rid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
					User Post
					</button>
					</div>';
				}
			}
			else {
				$sql1="SELECT * FROM friend_list WHERE friend_id='".$rid."' AND username='".$un."'";
				$result1=$mysqli->query($sql1);
				if($result1->num_rows <= 0) {
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">
					<button onclick="add_friend_request(\''.$row['username'].'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
					Add As Friend
					</button>
					</div>';
				}
				else {
					echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">Friend Request Sent</div>';
				}
			}
		}
	}
}
else {
	echo 'no';
	exit;
}
?>