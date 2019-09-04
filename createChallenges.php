<?php
/**
 * Created by IntelliJ IDEA.
 * User: omkar
 * Date: 4/1/2018
 * Time: 12:27 PM
 */

include("php".DIRECTORY_SEPARATOR."setup.php");

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$stmt = $mysqli->prepare("INSERT INTO user_challenges(desc_text, points, creator_user_id, duration, is_accepted, created_at ) VALUES (?, ?, ?, ?, ?, ?)");

$stmt->bind_param("siiiis", $desc_text, $points, $user_id, $duration, $is_accepted, $created_at);

session_start();
$user_id = $_SESSION['user_id'];
//$user_id = 18;

$data = json_decode($_POST['challenge_info']);

$desc_text = $data->desc_text;
$points = $data->points;
$duration = $data->duration;
$is_accepted = 0;
$created_at = date('Y-m-d H:i:s');

//$myObj->desc_text = "TEst desc";
//$myObj->points = 10;
//$myObj->duration = 1;
//$myObj->is_accepted = 0;
//$myObj->created_at = date('Y-m-d H:i:s');
//$myJSON = json_encode($myObj);
//
//
//$data = json_decode($myJSON);
//
//$desc_text = $data->desc_text;
//$points = $data->points;
//$duration = $data->duration;
//$is_accepted = 0;
//$created_at = date('Y-m-d H:i:s');

$stmt1 = $mysqli->prepare("SELECT points from user_points where user_id = ?");
$stmt1->bind_param("i", $user_id);




if (!$stmt1->execute()) {
    $response = array('result_code' => 400, 'result_message' => 'SQL Error','result'=> 'unsuccess');
    $response = json_encode($response);
    die($response);
}else{
    $stmt1->bind_result($aval_points);

    while($stmt1->fetch())
         $available_points = $aval_points;

    $stmt1->close();


    if($available_points < $points){
        $response = array('result_code' => 400, 'result_message' => 'Insufficient points to create challenge','result'=> 'unsuccess');
        $response = json_encode($response);
        echo $response;
    }
    else{

        if (!$stmt->execute()) {
            $response = array('result_code' => 400, 'result_message' => 'SQL Error','result'=> 'unsuccess');
            $response = json_encode($response);
            die($response);
}
        else {
            $response = array('result_code' => 100,'result'=> 'success');
            $response = json_encode($response);
            echo $response;
            $stmt->close();
}
    }



//    $response = array('code' => 200, 'message' => 'Success', 'data'=>$details);
//    $response = json_encode($response);
//    echo $response;
//    $stmt->close();
}


//$myObj->desc_text = "TEst desc";
//$myObj->points = 10;
//$myObj->duration = 1;
//$myObj->is_accepted = 0;
//$myObj->created_at = date('Y-m-d H:i:s');
//$myJSON = json_encode($myObj);
//
//
//$data = json_decode($myJSON);

//$desc_text = $data->desc_text;
//$points = $data->points;
//$duration = $data->duration;
//$is_accepted = 0;
//$created_at = date('Y-m-d H:i:s');

//if (!$stmt->execute()) {
//    $response = array('code' => 400, 'message' => 'Adding Challenge failed', 'error' => $stmt->error);
//    $response = json_encode($response);
//    echo $response;
//}
//else {
//    $response = array('code' => 200, 'message' => 'Success');
//    $response = json_encode($response);
//    echo $response;
//}

$mysqli->close();

?>