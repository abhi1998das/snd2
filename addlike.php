<?php

session_start();

require_once("db.php");

if(isset($_POST)) {
	$sql = "INSERT INTO likes (id_user, id_post, liked) VALUES ('$_SESSION[id_user]', '$_POST[id]', '1')";
	if($conn->query($sql)===TRUE) {
		echo "ok";
	} else {
		echo $sql;
	}
}

?>