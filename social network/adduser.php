<?php

session_start();

require_once("db.php");

if(isset($_POST)) {

	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$password = base64_encode(strrev(md5($password)));

	$sql = "INSERT INTO users(name, email, password) VALUES ('$name', '$email', '$password')";

	if($conn->query($sql)===TRUE) {
		$_SESSION['registeredSuccessfully'] = true;
		echo "ok";
	} else {
		echo "error";
	}
}