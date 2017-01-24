<?php
include('db.php');
$sql="CREATE TABLE user_profile (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL,
password VARCHAR(100) NOT NULL,
name VARCHAR(100),
email VARCHAR(100),
cell VARCHAR(100),
dob VARCHAR(100),
address VARCHAR(100),
photo VARCHAR(100)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'user_profile table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE user_message (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
inbox_id VARCHAR(100) NOT NULL,
from_user VARCHAR(100) NOT NULL,
to_user VARCHAR(100) NOT NULL,
message  LONGTEXT,
type VARCHAR(20),
status VARCHAR(20)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'user_message table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE room_message (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
room_id VARCHAR(300) NOT NULL,
from_user VARCHAR(100) NOT NULL,
message VARCHAR(3000),
type VARCHAR(20)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'room_message table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE room (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
description VARCHAR(500),
capacity VARCHAR(100) NOT NULL,
owner_id VARCHAR(100) NOT NULL
)";
if($mysqli->query($sql)==TRUE) {
	echo 'room table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE friend_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL,
friend_id VARCHAR(100) NOT NULL
)";
if($mysqli->query($sql)==TRUE) {
	echo 'friend_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE moderator_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
room_id VARCHAR(100) NOT NULL,
username VARCHAR(100) NOT NULL
)";
if($mysqli->query($sql)==TRUE) {
	echo 'moderator_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE user_online ( 
username VARCHAR(100) NOT NULL,
room_id VARCHAR(100) NOT NULL,
start VARCHAR(100),
end VARCHAR(100)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'user_online table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE friends_online ( 
username VARCHAR(100) NOT NULL,
start VARCHAR(100),
end VARCHAR(100)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'friends_online table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE status_update (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL,
status VARCHAR(3000)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'status_update table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE kick_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL,
room_id VARCHAR(100) NOT NULL,
start VARCHAR(100)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'kick_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE like_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
post_id VARCHAR(240) NOT NULL,
username VARCHAR(100) NOT NULL
)";
if($mysqli->query($sql)==TRUE) {
	echo 'kick_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}


$sql="CREATE TABLE comment_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
username VARCHAR(100) NOT NULL,
post_id VARCHAR(240) NOT NULL,
content VARCHAR(300)
)";
if($mysqli->query($sql)==TRUE) {
	echo 'comment_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}

$sql="CREATE TABLE banned_list (
id INT(240) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
type VARCHAR(100) NOT NULL,
username VARCHAR(100) NOT NULL,
from_id VARCHAR(100) NOT NULL
)";
if($mysqli->query($sql)==TRUE) {
	echo 'banned_list table Created<br>';
}
else {
	echo $mysqli->error;
	exit;
}
?>