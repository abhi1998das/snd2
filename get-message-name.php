<?php

require_once("db.php");

$sqlUser = "SELECT name FROM users WHERE id_user='$_POST[id]'";
$result = $conn->query($sqlUser);
if($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	echo $row['name'];
}