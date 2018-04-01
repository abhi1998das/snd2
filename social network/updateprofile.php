<?php

session_start();

require_once("db.php");

if(isset($_POST)) {

	$uploadOk = true; 

	$folder_dir = "uploads/profile/";

	$base = basename($_FILES['image']['name']); // mydocs/images/myprofile.jpg -> myprofile.jpg

	$imageFileType = pathinfo($base, PATHINFO_EXTENSION); // .png .jpg

	$file = uniqid() . "." . $imageFileType;    

	$filename = $folder_dir . $file;  

	if(file_exists($_FILES['image']['tmp_name'])) {
		if($imageFileType == 'jpg' || $imageFileType == 'png') {
			if($_FILES['image']['size'] < 5000000) {
				move_uploaded_file($_FILES['image']['tmp_name'], $filename);
			} else {
				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed: 5MB";
				$uploadOk = false;
			}
		} else {
			$_SESSION['uploadError'] = "Wrong Format. Only jpg or png allowed.";
			$uploadOk = false;
		}
	} else {
		$_SESSION['uploadError'] = "Something Went Wrong. File Not Uploaded.";
		$uploadOk = false;
	}

	if($uploadOk == false) {
		header("Location: profile.php");
		exit();
	}

	$sql = "SELECT * FROM users WHERE id_user='$_SESSION[id_user]'";
	$result = $conn->query($sql);
	if($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		if($row['profileimage'] != '') {
			unlink("uploads/profile/".$row['profileimage']);
		}
	}

	$name = mysqli_real_escape_string($conn, $_POST['name']);
	$designation = mysqli_real_escape_string($conn, $_POST['designation']);
	$degree = mysqli_real_escape_string($conn, $_POST['degree']);
	$university = mysqli_real_escape_string($conn, $_POST['university']);
	$city = mysqli_real_escape_string($conn, $_POST['city']);
	$country = mysqli_real_escape_string($conn, $_POST['country']);
	$skills = mysqli_real_escape_string($conn, $_POST['skills']);
	$aboutme = mysqli_real_escape_string($conn, $_POST['aboutme']);

	$sql = "UPDATE users SET name='$name', designation='$designation', degree='$degree', university='$university', city='$city', country='$country', skills='$skills', aboutme='$aboutme', profileimage='$file' WHERE id_user='$_SESSION[id_user]'";

	if($conn->query($sql) === TRUE) {
		header("Location: profile.php");
		exit();
	} else {
		echo $conn->error;
	}

	$conn->close();

}