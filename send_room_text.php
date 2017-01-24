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
if(isset($_GET['rid']) && !empty($_GET['rid']) && isset($_POST['rtext']) && !empty($_POST['rtext'])) {
	$rid=$_GET['rid'];
	$rtext=$_POST['rtext'];
	$com=explode('>',$rtext);
	$sql1="SELECT * FROM kick_list WHERE room_id='".$rid."' AND username='".$un."'";
	$result1=$mysqli->query($sql1);
	if($com[0]=="m" && $result1->num_rows < 1) {
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$un."'";
		$result=$mysqli->query($sql);
		if($result->num_rows >0) {
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
		$result=$mysqli->query($sql);
		if($result->num_rows < 1) {
			$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
			$result=$mysqli->query($sql);
			if($result->num_rows < 1) {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','username doesnt exist','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
			else {
				$sql="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
				$result=$mysqli->query($sql);
				if($result->num_rows < 1) {
					$u=$com[1];
					$sql="INSERT INTO moderator_list VALUES('','$rid','$u')";
					$mysqli->query($sql);
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u is now a moderator','text')";
					$mysqli->query($sql);
					echo 'ok';
				}
				else {
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','moderator already exist','text')";
					$mysqli->query($sql);
					echo 'ok';
				}
			}
		}
		else {
			$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are owner. you dont have to be moderator','text')";
			$mysqli->query($sql);
			echo 'ok';
		}
		}
		else {
			$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are not owner','text')";
			$mysqli->query($sql);
			echo 'ok';
		}
	}
	else if($com[0]=="dm" && $result1->num_rows < 1) {
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$un."'";
		$result=$mysqli->query($sql);
		if($result->num_rows >0) {
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
		$result=$mysqli->query($sql);
		if($result->num_rows < 1) {
			$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
			$result=$mysqli->query($sql);
			if($result->num_rows < 1) {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','username doesnt exist','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
			else {
				$sql="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
				$result=$mysqli->query($sql);
				if($result->num_rows > 0) {
					$u=$com[1];
					$query="DELETE FROM moderator_list WHERE room_id='".$rid."' AND username='".$u."'";
					$mysqli->query($query);
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u is demoderated','text')";
				$mysqli->query($sql);
					echo 'ok';
				}
				else {
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','moderator doesnt exist','text')";
					$mysqli->query($sql);
					echo 'ok';
				}
			}
		}
		else {
			$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are owner. you cant be unmoderated','text')";
			$mysqli->query($sql);
			echo 'ok';
		}
		}
		else {
			$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are not owner','text')";
			$mysqli->query($sql);
			echo 'ok';
		}
	}
	else if($com[0]=="k" && $result1->num_rows < 1) {
		//kick user
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$un."'";
		$result=$mysqli->query($sql);
		if($result->num_rows >0) {
			$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
			$result=$mysqli->query($sql);
			$sql0="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
			$result0=$mysqli->query($sql0);
			$sql1="SELECT * FROM kick_list WHERE room_id='".$rid."' AND username='".$com[1]."'";
			$result1=$mysqli->query($sql1);
			$sql2="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
			$result2=$mysqli->query($sql2);
			if($result->num_rows > 0 && $result0->num_rows<1 && $result1->num_rows<1 && $result2->num_rows <1) {
				$u=$com[1];
				$currenttime=strtotime("now");
				$endtime=$currenttime+300;
				$sql="INSERT INTO kick_list VALUES('','$u','$rid','$endtime')";
				$mysqli->query($sql);
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u has been kicked by $un','text')";
				$mysqli->query($sql);
				
				
				
				$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0) {
	$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	if($mysqli->query($query)==TRUE) {

	}
	}
				
				
				
				echo 'ok';
			}
			else {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','you cant kick','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
		}
		else {
			$sql="SELECT * FROM moderator_list WHERE username='".$un."' AND room_id='".$rid."'";
			$result=$mysqli->query($sql);
			if($result->num_rows > 0) {
				$sql="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
				$result=$mysqli->query($sql);
				if($result->num_rows > 0) {
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','You cant kick a moderator','text')";
					$mysqli->query($sql);
					echo 'ok';
				}
				else {
					$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
					$result=$mysqli->query($sql);
					$sql0="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
					$result0=$mysqli->query($sql0);
					$sql1="SELECT * FROM kick_list WHERE room_id='".$rid."' AND username='".$com[1]."'";
					$result1=$mysqli->query($sql1);
					if($result->num_rows > 0 && $result0->num_rows<1 && $result1->num_rows<1) {
						$u=$com[1];
						$currenttime=strtotime("now");
						$endtime=$currenttime+300;
						$sql="INSERT INTO kick_list VALUES('','$u','$rid','$endtime')";
						$mysqli->query($sql);
						$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u has been kicked by $un','text')";
						$mysqli->query($sql);
						
						
						$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0) {
	$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	if($mysqli->query($query)==TRUE) {

	}
	}
						
						
						
						
						echo 'ok';
					}
					else {
						$sql="INSERT INTO room_message VALUES('','$rid','BOT','you cant kick','text')";
						$mysqli->query($sql);
						echo 'ok';
					}
				}
			}
			else {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are not a moderator','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
		}
	}
	else if($com[0]=="b") {
		//ban user
		$sql="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$un."'";
		$result=$mysqli->query($sql);
		if($result->num_rows >0) {
			$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
			$result=$mysqli->query($sql);
			$sql0="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
			$result0=$mysqli->query($sql0);
			$sql1="SELECT * FROM banned_list WHERE type='room' AND from_id='".$rid."' AND username='".$com[1]."'";
			$result1=$mysqli->query($sql1);
			$sql2="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
			$result2=$mysqli->query($sql2);
			if($result->num_rows > 0 && $result0->num_rows<1 && $result1->num_rows<1 && $result2->num_rows <1) {
				$u=$com[1];
				$currenttime=strtotime("now");
				$endtime=$currenttime+300;
				$sql="INSERT INTO banned_list VALUES('','room','$u','$rid')";
				$mysqli->query($sql);
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u has been Banned from this room by $un','text')";
				$mysqli->query($sql);
				
				
				
				$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0) {
	$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	if($mysqli->query($query)==TRUE) {

	}
	}
				
				
				
				echo 'ok';
			}
			else {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','you cant Ban','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
		}
		else {
			$sql="SELECT * FROM moderator_list WHERE username='".$un."' AND room_id='".$rid."'";
			$result=$mysqli->query($sql);
			if($result->num_rows > 0) {
				$sql="SELECT * FROM moderator_list WHERE username='".$com[1]."' AND room_id='".$rid."'";
				$result=$mysqli->query($sql);
				if($result->num_rows > 0) {
					$sql="INSERT INTO room_message VALUES('','$rid','BOT','You cant Ban a moderator','text')";
					$mysqli->query($sql);
					echo 'ok';
				}
				else {
					$sql="SELECT * FROM user_profile WHERE username='".$com[1]."'";
					$result=$mysqli->query($sql);
					$sql0="SELECT * FROM room WHERE id='".$rid."' AND owner_id='".$com[1]."'";
					$result0=$mysqli->query($sql0);
					$sql1="SELECT * FROM banned_list WHERE type='room' AND from_id='".$rid."' AND username='".$com[1]."'";
					$result1=$mysqli->query($sql1);
					if($result->num_rows > 0 && $result0->num_rows<1 && $result1->num_rows<1) {
						$u=$com[1];
						$currenttime=strtotime("now");
						$endtime=$currenttime+300;
						$sql="INSERT INTO banned_list VALUES('','room','$u','$rid')";
						$mysqli->query($sql);
						$sql="INSERT INTO room_message VALUES('','$rid','BOT','$u has been Banned from this room by $un','text')";
						$mysqli->query($sql);
						
						
						$sql="SELECT * FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	$result=$mysqli->query($sql);
	if($result->num_rows>0) {
	$query="DELETE FROM user_online WHERE room_id='".$rid."' AND username='".$com[1]."'";
	if($mysqli->query($query)==TRUE) {

	}
	}
						
						
						
						
						echo 'ok';
					}
					else {
						$sql="INSERT INTO room_message VALUES('','$rid','BOT','you cant Ban','text')";
						$mysqli->query($sql);
						echo 'ok';
					}
				}
			}
			else {
				$sql="INSERT INTO room_message VALUES('','$rid','BOT','You are not a moderator','text')";
				$mysqli->query($sql);
				echo 'ok';
			}
		}
		//ban user end
	}
	else if($com[0]=="ub") {
		//unban user
		$sql1="SELECT * FROM banned_list WHERE type='room' AND from_id='".$rid."' AND username='".$com[1]."'";
		$result1=$mysqli->query($sql1);
		if($result1->num_rows > 0) {
			$query2="DELETE FROM banned_list WHERE type='room' AND from_id='".$rid."' AND username='".$com[1]."'";
			if($mysqli->query($query2)==TRUE) {
				$u=$com[1];
				$sql3="INSERT INTO room_message VALUES('','$rid','BOT','$u has been UnBanned from this room by $un','text')";
				$mysqli->query($sql3);
			}
			else {
				$sql3="INSERT INTO room_message VALUES('','$rid','BOT','Not Allowed','text')";
				$mysqli->query($sql3);
			}
		}
		else {
			$sql3="INSERT INTO room_message VALUES('','$rid','BOT','Not in Banned List','text')";
			$mysqli->query($sql3);
		}
		echo 'ok';
		//unban user end
	}
	else {
		$sql1="SELECT * FROM kick_list WHERE room_id='".$rid."' AND username='".$un."'";
		$result1=$mysqli->query($sql1);
		if($result1->num_rows < 1 ) {
	$sql="INSERT INTO room_message VALUES('','$rid','$un','$rtext','text')";
	if($mysqli->query($sql)==TRUE) {
		echo'ok';
	}
	else {
		echo'error';
	}
	}
	else {
		echo'error';
	}
}
}
else {
	echo 'empty';
	exit;
}
?>