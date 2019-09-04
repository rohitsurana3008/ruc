<?php

include("php".DIRECTORY_SEPARATOR."setup.php");

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

$uploadOk = 1;

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$FileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
    if (file_exists($target_file)) {
        header('location: cmhelp.php?error=fileexists');
    }
    else if($_FILES["fileToUpload"]["size"] > 50000000)
    {
        header('location: cmhelp.php?error=filetoolarge');
    }
    else if($FileType != "jpg" && $FileType != "png" && $FileType != "jpeg" && $FileType != "gif" && $FileType != "jpeg")
    {
        header('location: cmhelp.php?error=fileformatnotsupported');
    }
    else
    {
        $newname = time() .rand(100000,50000);

        if((move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir .$newname .".".$FileType)))
        {
            $stmt = $mysqli->prepare("INSERT INTO community_help(user_id, desc_text, resource_url, time_taken, points, reported_at) VALUES (?, ?, ?, ?, ?, ?)");

            $stmt->bind_param("isssis", $user_id, $desc_text, $resource_url, $time_taken, $points, $reported_at);


            $user_id = $_SESSION['user_id'];
            //$user_id = 18;
            //$desc_text = $_POST['desc_text'];
            $desc_text = $_POST['desc'];
            $resource_url = $target_dir.$newname.".".$FileType;
            $time_taken = $_POST['time_taken'];
            //$time_taken = '60';
            $points = 0;
            if($time_taken == '30'){
                $points = 10;
            }
            else if($time_taken == '60'){
                $points = 20;
            }
            else if($time_taken == '90'){
                $points = 30;
            }
            else
            {
                $points = 40;
            }

            $reported_at = date('Y-m-d H:i:s');

            if (!$stmt->execute()) {
                header('location: cmhelp.php?error=ServerDown');
                die($response);

            }
            else {

                $stmt->close();

                $stmt = $mysqli->prepare("UPDATE user_points SET points= points + ? WHERE user_id=?");
                $stmt->bind_param("ii", $points, $user_id);

                if (!$stmt->execute()) {
                    header('location: cmhelp.php?error=ServerDown');
                    die($response);
                } else {
                    $stmt->close();
                    header('location: cmhelp.php?error=success');
                }
            }
        }
        else
        {
            header('location: cmhelp.php?error=ErrorUploadingFile');
        }
    }


