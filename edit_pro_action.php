<?php
session_start();
if(isset($_SESSION['login_user'])) {
	include('db.php');
	$un=$_SESSION['login_user'];
}
else {
	header("Location: index.php");
	exit;
}


function upload_media_pu($user) {
	global $mysqli;
	$un=$user;
	if(isset($_FILES['ione']['name'])) {
	function getExtension($str) {
        $i = strrpos($str,".");
        if (!$i) { return ""; }
        $l = strlen($str) - $i;
        $ext = substr($str,$i+1,$l);
        return $ext;
	}
	$filename = stripslashes($_FILES['ione']['name']);
  	$extension = getExtension($filename);
 	$extension = strtolower($extension);
	if ($extension == "bmp" || $extension == "jpg" || $extension == "jpeg" || $extension == "png" || $extension == "gif")
	{
		if ($_FILES['ione']["error"] > 0)
		{
			echo 'fe';
			exit;
		}
		else
		{
			if($_FILES['ione']['size']>2000000) {
				echo 'fs';
				exit;
			}
			else {
			move_uploaded_file($_FILES['ione']["tmp_name"],"uploads/pp_".$un.'.'.$extension);
			$ppp=$un.'.'.$extension;
			$sql="UPDATE user_profile SET photo='$ppp' WHERE username='$un'";
			$mysqli->query($sql);
			echo $un.'.'.$extension;
			exit;
			}
		}
    }
	else
	{
		echo "fl";
		exit;
	}
	}
	else {
		echo 'fe';
		exit;
	}
}


if(isset($_GET['edit']) && $_GET['edit']=='info') {
	if(isset($_GET['fullname']) && isset($_GET['address']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['website'])) {
			if(empty($_GET['fullname'])) { echo 'fn'; exit; }
			if(empty($_GET['address'])) { echo 'ad'; exit; }
			if(empty($_GET['email'])) { echo 'em'; exit; }
			if(empty($_GET['phone'])) { echo 'ph'; exit; }
			if(empty($_GET['website'])) { echo 'ws'; exit; }
			$fn=$_GET['fullname'];
			$add=$_GET['address'];
			$em=$_GET['email'];
			$ph=$_GET['phone'];
			$ws=$_GET['website'];
			$sql="UPDATE user_profile SET name='$fn', address='$add', email='$em', cell='$ph', dob='$ws' WHERE username='$un'";
			$mysqli->query($sql);
			if($mysqli->query($sql)==TRUE) {
				echo 'ok';
			}
			else {
				echo 'error';
			}
	}
}
else if(isset($_GET['edit']) && $_GET['edit']=='picture') {
	 upload_media_pu($un);
}
?>