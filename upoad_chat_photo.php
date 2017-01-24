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
function generateRandomString($length = 30) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function upload_media_pu() {
	$un=$_SESSION['login_user'];
	global $mysqli;
	$rid=$_GET['rid'];
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
			if($_FILES['ione']['size']>200000) {
				echo 'fs';
				exit;
			}
			else {
			$fmm="messenger_".$un.'_'.generateRandomString().'.'.$extension;
			move_uploaded_file($_FILES['ione']["tmp_name"],'shared-photo/'.$fmm);
			$sql="INSERT INTO room_message VALUES('','$rid','$un','$fmm','image')";
			$mysqli->query($sql);
			echo 'ok';
			}
		}
    }
	else
	{
		echo "fl";
		exit;
	}
}
if(isset($_GET['rid']) && !empty($_GET['rid']) && isset($_FILES['ione']['name'])) {
	upload_media_pu();
}
else {
	echo 'empty';
	exit;
}
?>