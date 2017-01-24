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
	if (isset($_GET['p'])) { if($_GET['p']>=0) $p=$_GET['p']; else $p=0; } else $p=0;
	$sql="SELECT * FROM status_update WHERE username='".$uid."' ORDER BY id DESC LIMIT ".$p.",9";
		$result=$mysqli->query($sql);
		if($result->num_rows > 0) {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_profile('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Profile
			</button>
			</div>';
			while($row = $result->fetch_assoc()) {
				echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">'.substr($row['status'],0,70).'...</div>';
				echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">';
				$sql_l="SELECT * FROM like_list WHERE post_id='".$row['id']."'";
				$result_l=$mysqli->query($sql_l);
				if($result_l->num_rows > 0) {
					echo 'Likes: '.$result_l->num_rows.' - ';
				}
				else {
					echo 'Likes: 0 - ';
				}
				$sql_l="SELECT * FROM comment_list WHERE post_id='".$row['id']."'";
				$result_l=$mysqli->query($sql_l);
				if($result_l->num_rows > 0) {
					echo 'Comments: '.$result_l->num_rows.' - ';
				}
				else {
					echo 'comments: 0 - ';
				}
				echo'<button onclick="show_post('.$row['id'].','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				See Post
				</button>
				</div>';
			}
			if($p<=0) {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="next_postlist(\''.$uid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Next
			</button>
			</div>';
			}
			else {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="prev_postlist(\''.$uid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Prev
			</button>
			';
			echo '<button onclick="next_postlist(\''.$uid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Next
			</button>
			</div>';	
			}
		}
		else {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_profile('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Profile
			</button>
			</div>';
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="prev_postlist(\''.$uid.'\','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Prev
			</button>
			</div>';
		}
}
else {
	echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_profile('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Profile
			</button>
			</div>';
}
?>