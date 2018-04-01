<?php


session_start();

require_once("db.php");

$sqlUser = "SELECT online FROM users WHERE id_user='$_POST[id_user]'";
$result = $conn->query($sqlUser);
if($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$viewed = $row['online'];
}


$message = mysqli_real_escape_string($conn, $_POST['message']);

$sql = "INSERT INTO messages (id_from, id_to, message, viewed) VALUES ('$_SESSION[id_user]','$_POST[id_user]', '$message', '$viewed')";
if($conn->query($sql) == true) {
	echo "ok";
} else {
	echo $conn->error;
}

?>