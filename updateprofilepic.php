<?php
session_start();
include "php/setup.php";
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

//echo $target_file;
$uploadOk = 1;
$type = 'image';
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if file already exists
if (file_exists($target_file)) {
    //echo "Sorry, file already exists.";
	echo '207';
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    echo "210";
    $uploadOk = 0;
}
// Allow certain file formats

switch($type){
	case "image":
		if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "jpeg") {
			echo '206';
			$uploadOk = 0;
		}
		break;		
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {

} else {
	// if everything is ok, try to upload file
	$newname = time() .rand(100000,50000);
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir .$newname .".".$FileType)) {
		
		$user_id = $_SESSION["user_id"];
		$profile = ORM::for_table('users')->where('user_id', $user_id)->find_one();
		$profile->photo = "uploads/".$newname .".".$FileType;
		$profile->save();
		$_SESSION['user_photo'] = "uploads/".$newname .".".$FileType;
		
		header('location: profile.php');
    } else {
        echo "208";
    }
}
?>