<?php

session_start();

require_once("db.php");

if(isset($_POST)) {

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

	$password = base64_encode(strrev(md5($password)));

	$sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
	$result = $conn->query($sql);

	if($result->num_rows > 0) {
		$row = $result->fetch_assoc();

		$sql1 = "UPDATE users SET online='1' WHERE id_user='$row[id_user]'";
		$conn->query($sql1);

		$_SESSION['id_user'] = $row['id_user'];
		$_SESSION['name'] = $row['name'];

		echo "ok";
	} else {
		echo "error";
	}
}