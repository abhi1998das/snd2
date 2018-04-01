<?php

session_start();

require_once("db.php");

if(isset($_POST['name']) && isset($_POST['color'])) {

	$sql = "INSERT INTO events (id_user, name, color) VALUES ('$_SESSION[id_user]', '$_POST[name]', '$_POST[color]')";
	$conn->query($sql);

}