<?php

session_start();

require_once("db.php");

if(isset($_POST)) {
	$sql = "INSERT INTO event_calendar (id_user, title, day, month, year, bgColor, borderColor) VALUES ('$_SESSION[id_user]', '$_POST[title]', '$_POST[day]', '$_POST[month]', '$_POST[year]', '$_POST[bgColor]', '$_POST[borderColor]')";
	$conn->query($sql);
}