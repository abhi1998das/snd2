<?php

session_start();

require_once("db.php");

$sql = "DELETE FROM user_followers WHERE id_user='$_SESSION[id_user]' AND id_userfollower='$_GET[id]'";

if($conn->query($sql) == true) {
	header("Location: ". $_SESSION['callFrom']);
	exit();
} else {
	echo $conn->error;
}