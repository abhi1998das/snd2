<?php

session_start();

require_once("db.php");

$sql = "INSERT INTO user_followers (id_user, id_userfollower) VALUES ('$_SESSION[id_user]', '$_GET[id]')";

if($conn->query($sql) == true) {
	header("Location: ". $_SESSION['callFrom']);
	exit();
} else {
	echo $conn->error;
}