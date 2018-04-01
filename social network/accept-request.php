<?php

session_start();

require_once("db.php");


if(isset($_GET)) {
	$sql = "SELECT * FROM friendrequest WHERE id_user='$_SESSION[id_user]' AND id_friend='$_GET[id]'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		$sql1 = "DELETE FROM friendrequest WHERE id_user='$_SESSION[id_user]' AND id_friend='$_GET[id]'";
		if($conn->query($sql1) === TRUE) {
			$sql2 = "INSERT INTO friends (id_user, id_frienduser) VALUES ('$_GET[id]', '$_SESSION[id_user]')";
			if($conn->query($sql2) === TRUE) {
				$sql3 = "INSERT INTO friends (id_user, id_frienduser) VALUES ('$_SESSION[id_user]', '$_GET[id]')";
				if($conn->query($sql3) === TRUE) {
					header("Location: friends.php");
					exit();
				} else {
					echo $conn->error;
				}
			} else {
				echo $conn->error;
			}
		}
	}
}