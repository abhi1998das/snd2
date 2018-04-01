<?php

session_start();

require_once("db.php");


if(isset($_GET)) {
	$sql = "SELECT * FROM friendrequest WHERE id_user='$_GET[id]' AND id_friend='$_SESSION[id_user]'";
	$result = $conn->query($sql);
	if($result->num_rows == 0) {
		$sql1 = "INSERT INTO friendrequest (id_user, id_friend) VALUES ('$_GET[id]', '$_SESSION[id_user]')";
		if($conn->query($sql1) === TRUE) {
			header("Location: friends.php");
			exit();
		} else {
			echo $conn->error;
		}
	}
}