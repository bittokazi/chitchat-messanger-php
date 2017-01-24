<?php
if(isset($_GET['un']) && isset($_GET['fullname']) && isset($_GET['address']) && isset($_GET['email']) && isset($_GET['phone']) && isset($_GET['website'])) {
	$cookie_value=$_GET['un'];
	setcookie('un', $cookie_value, time() + (60), "/");
	$cookie_value=$_GET['fullname'];
	setcookie('fullname', $cookie_value, time() + (60), "/");
	$cookie_value=$_GET['address'];
	setcookie('address', $cookie_value, time() + (60), "/");
	$cookie_value=$_GET['email'];
	setcookie('email', $cookie_value, time() + (60), "/");
	$cookie_value=$_GET['phone'];
	setcookie('phone', $cookie_value, time() + (60), "/");
	$cookie_value=$_GET['website'];
	setcookie('website', $cookie_value, time() + (60), "/");
}
?>