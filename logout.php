<?php
session_start();
if(isset($_SESSION['login_user'])) {
session_unset();
session_destroy();
header("Location: login.php");
} else {
header("Location: login.php");
}
?>