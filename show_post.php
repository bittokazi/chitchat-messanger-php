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
	$sql="SELECT * FROM status_update WHERE id='".$uid."' ORDER BY id DESC LIMIT 0,1";
		$result=$mysqli->query($sql);
		if($result->num_rows > 0) {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_postlist('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Post List
			</button>
			</div>';
			while($row = $result->fetch_assoc()) {
				echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">'.$row['status'].'</div>';
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
				$sql_l="SELECT * FROM like_list WHERE post_id='".$row['id']."' AND username='".$un."'";
				$result_l=$mysqli->query($sql_l);
				if($result_l->num_rows > 0) {
					echo '<button onclick="like_post('.$row['id'].','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Unlike
			</button>';
				}
				else {
					echo '<button onclick="like_post('.$row['id'].','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Like
			</button>';
				}
				echo'</div>';
				echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
				Comment:<br>
				<textarea id="p_comment'.$did.'"></textarea><br>
				<button onclick="add_comment('.$uid.','.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Comment
				</button>
				</div>';
				
				echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
				Comment List:
				</div>';
				
				
				$sql_l="SELECT * FROM comment_list WHERE post_id='".$row['id']."' ORDER BY id DESC";
				$result_l=$mysqli->query($sql_l);
				if($result_l->num_rows > 0) {
					while($row_l = $result_l->fetch_assoc()) {
						echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
						'.$row_l['username'].' : '.$row_l['content'].'
						</div>';
					}
				}
				else {
					echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
						No Comments Yet
						</div>';
				}
				
			}
		}
		else {
			echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_postlist('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Post List
			</button>
			</div>';
		}
}
else {
	echo '<div style="padding:5px; width:350px; border-bottom:1px solid black; float:left;">
			<button onclick="go_back_postlist('.$did.')" style="background: none; border-radius: 20px; padding: 5px; font-size: 12px; height:30px; cursor:pointer;">
				Go Back to Post List
			</button>
			</div>';
}
?>