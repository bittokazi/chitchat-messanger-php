<?php
include('db.php');

function upload_media_pu() {
	$un=$_GET['un'];
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
			if($_FILES['ione']['size']>500000) {
				echo 'fs';
				exit;
			}
			else {
			move_uploaded_file($_FILES['ione']["tmp_name"],"uploads/pp_".$un.'.'.$extension);
			return $un.'.'.$extension;
			}
		}
    }
	else
	{
		echo "fl";
		exit;
	}
}


if(isset($_GET['un']) && !empty($_GET['un'])) {
	$un=$_GET['un'];
	$sql="SELECT * FROM user_profile WHERE username='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0) {
		echo 'un';
		exit;
	}
	else {
		if(isset($_GET['pw']) && !empty($_GET['pw'])) {
			if(isset($_FILES['ione']['name']) && isset($_GET['fullname']) && isset($_GET['address']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['website'])) {
			if(empty($_GET['fullname'])) { echo 'fn'; exit; }
			if(empty($_GET['address'])) { echo 'ad'; exit; }
			if(empty($_GET['email'])) { echo 'em'; exit; }
			if(empty($_GET['phone'])) { echo 'ph'; exit; }
			if(empty($_GET['website'])) { echo 'ws'; exit; }
			$un=$_GET['un'];
			$pw=md5($_GET['pw']);
			$fn=$_GET['fullname'];
			$add=$_GET['address'];
			$em=$_GET['email'];
			$ph=$_GET['phone'];
			$ws=$_GET['website'];
			$pp=upload_media_pu();
				$sql="INSERT INTO user_profile VALUES('','".$un."','".$pw."','".$fn."','".$em."','".$ph."','".$ws."','".$add."','".$pp."')";
				if($mysqli->query($sql)==TRUE) {
					echo 'yes';
					exit;
				}
				else {
					echo 'no';
					exit;
				}
			
			}
			else {
				echo 'all';
				exit;
			}
		}
		else {
			echo 'pw';
			exit;
		}
	}
}
?>