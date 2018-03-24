<?php 


session_start();

require_once("db.php");

if(isset($_POST['id'])) {
	$sql = "DELETE FROM event_calendar WHERE id_calendar='$_POST[id]'";
	if($conn->query($sql) == true) {
		echo 'ok';
	}
}