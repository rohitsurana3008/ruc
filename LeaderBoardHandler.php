<?php

include("php".DIRECTORY_SEPARATOR."setup.php");

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check connection
if ($mysqli->connect_error) {
die("Connection failed: " . $mysqli->connect_error);
}

$stmt = $mysqli->prepare("SELECT U.user_name, U.photo, P.points FROM users U, user_points P WHERE U.user_id = P.user_id ORDER BY P.points DESC");

if (!$stmt->execute()) {
    $response = array('code' => 400, 'message' => 'Retrieving Details failed','error'=> $stmt->error);
    $response = json_encode($response);
    echo $response;
}else{
    $stmt->bind_result($user_name, $photo,$points);
    $details=array();
    while($stmt->fetch()){
        array_push($details, array('user_name' => $user_name, 'photo' => $photo, 'points' => $points));
    }

    $response = array('code' => 200, 'message' => 'Success', 'data'=>$details);
    $response = json_encode($response);
    echo $response;
    $stmt->close();
}

$mysqli->close();