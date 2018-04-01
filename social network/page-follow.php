<?php

session_start();

require_once("db.php");

$sql = "INSERT INTO page_followers (id_user, id_page) VALUES ('$_SESSION[id_user]', '$_GET[id]')";

if($conn->query($sql) == true) {
	header("Location: ". $_SESSION['callFrom']);
	exit();
} else {
	echo $conn->error;
}