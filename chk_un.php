<?php
include('db.php');
if(isset($_GET['un']) && !empty($_GET['un'])) {
	$un=$_GET['un'];
	$sql="SELECT * FROM user_profile WHERE username='".$un."'";
	$result=$mysqli->query($sql);
	if($result->num_rows > 0) {
		echo 'no';
	}
	else {
		echo 'yes';
	}
}
else {
	echo 'empty';
}
?>