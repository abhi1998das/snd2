<?php

session_start();

require_once("db.php");

$sql1 = "UPDATE users SET online='0' WHERE id_user='$_SESSION[id_user]'";
$conn->query($sql1);

session_unset();
session_destroy();

header("Location: login.php");
exit();