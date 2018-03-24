<?php

require_once("db.php");

if(isset($_POST)) {
	$email = mysqli_real_escape_string($conn, $_POST['email']); 

	$sql = "SELECT email FROM users WHERE email='$email'";
	$result = $conn->query($sql);

	if($result->num_rows > 0) {
		echo "Error";
	} else {
		echo "Ok";
	}
}