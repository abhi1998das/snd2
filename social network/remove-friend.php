<?php

session_start();

require_once("db.php");


if(isset($_GET)) {
	$sql = "SELECT * FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		$sql1 = "DELETE FROM friends WHERE id_user='$_SESSION[id_user]' AND id_frienduser='$_GET[id]'";
		if($conn->query($sql1) === TRUE) {
			$sql2 = "DELETE FROM friends WHERE id_user='$_GET[id]' AND id_frienduser='$_SESSION[id_user]'";
			if($conn->query($sql2) === TRUE) {
				header("Location: friends.php");
				exit();				
			}			
		}
	}
}