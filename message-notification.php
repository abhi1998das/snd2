<?php

session_start();
require_once('db.php');

$sql = "SELECT * FROM messages WHERE id_from='$_POST[id]' AND id_to='$_SESSION[id_user]' AND viewed='0'";
$result = $conn->query($sql);
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$sql1 = "UPDATE messages SET viewed='1' WHERE id_message='$row[id_message]'";
		$conn->query($sql1);
	}
	echo "ok";
}