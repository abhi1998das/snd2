<?php 


session_start();

require_once("db.php");

if(isset($_POST['id'])) {
	$sql = "DELETE FROM events WHERE id_event='$_POST[id]'";
	if($conn->query($sql) == true) {
		echo 'ok';
	}
}