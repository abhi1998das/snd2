<?php

session_start();

require_once("db.php");

if(isset($_POST)) {

	preg_match('~(?:https?://)?(?:www.)?(?:youtube.com|youtu.be)/(?:watch\?v=)?([^\s]+)~', $_POST['description'], $match);

	if($match[1] == "") {
		$youtube = "";
	} else {
		$youtube = $match[1];
	}


	$description = mysqli_real_escape_string($conn, $_POST['description']);

	$uploadOk = true; 

	$folder_dir = "uploads/post/";

	$base = basename($_FILES['image']['name']); // mydocs/images/myprofile.jpg -> myprofile.jpg

	$imageFileType = pathinfo($base, PATHINFO_EXTENSION); // .png .jpg

	$file = "";

	if(file_exists($_FILES['image']['tmp_name'])) {
		if($imageFileType == 'jpg' || $imageFileType == 'png') {
			if($_FILES['image']['size'] < 5000000) {
					
				$file = uniqid() . "." . $imageFileType;  

				$filename = $folder_dir . $file;  

				move_uploaded_file($_FILES['image']['tmp_name'], $filename);
			} else {
				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed: 5MB";
				$uploadOk = false;
			}
		} else {
			$_SESSION['uploadError'] = "Wrong Format. Only jpg or png allowed.";
			$uploadOk = false;
		}
	}

	$uploadOk1 = true; 

	$base = basename($_FILES['video']['name']); 

	$videoFileType = pathinfo($base, PATHINFO_EXTENSION); // .png .jpg

	$file1 = "";

	if(file_exists($_FILES['video']['tmp_name'])) {
		if($videoFileType == 'mp4') {
			if($_FILES['video']['size'] < 25000000) {
					
				$file1 = uniqid() . "." . $videoFileType;  

				$filename = $folder_dir . $file1;  

				move_uploaded_file($_FILES['video']['tmp_name'], $filename);
			} else {
				$_SESSION['uploadError'] = "Wrong Size. Max Size Allowed: 25MB";
				$uploadOk = false;
			}
		} else {
			$_SESSION['uploadError'] = "Wrong Format. Only mp4 allowed.";
			$uploadOk = false;
		}
	}

	if($uploadOk == false || $uploadOk1 == false) {
		header("Location: " . $_SESSION['callFrom']);
		exit();
	}

	$sql = " INSERT INTO post (id_user, description, image, video, youtube) VALUES ('$_SESSION[id_user]', '$description', '$file', '$file1', '$youtube')";
	if($conn->query($sql)===TRUE) {
		header("Location: "  . $_SESSION['callFrom']);
		exit();
	} else {
		echo $conn->error;
	}
}