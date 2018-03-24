<?php

session_start();

require_once("db.php");

if(isset($_POST)) {
	$sql = "INSERT INTO comments (id_user, id_friend, id_post, comment) VALUES ('$_SESSION[id_user]', '$_POST[user]', '$_POST[id]', '$_POST[comment]')";
	if($conn->query($sql)===TRUE) {
		echo "ok";
	} else {
		echo $sql;
	}
}

?>