<?php

include("php".DIRECTORY_SEPARATOR."setup.php");

// Create connection
$mysqli = new mysqli($host, $user, $pass, $database);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}


$stmt = $mysqli->prepare("SELECT genreated_by FROM signup_token S, user_bonuses U WHERE S.is_used = 1 AND S.genreated_by = U.user_id AND U.referal_bonus = 0
GROUP BY genreated_by HAVING COUNT(*) >= 5");

if (!$stmt->execute()) {
    $response = array('code' => 400, 'message' => 'Script failed','error'=> $stmt->error);
    $response = json_encode($response);
    echo $response;
}else{
    $stmt->bind_result($user_id);
    $details=array();
    while($stmt->fetch()){
        array_push($details, $user_id);
    }

//    $response = array('code' => 200, 'message' => 'Success', 'data'=>$details);
//    $response = json_encode($response);
//    echo $response;
       $stmt->close();
        updatePoints($details,$mysqli);

}


function updatePoints($details,$mysqli)
{
    $stmt = $mysqli->prepare("UPDATE user_points SET points= points + 20 WHERE user_id=?");
    $stmt1 = $mysqli->prepare("UPDATE user_bonuses SET referal_bonus= 1  WHERE user_id=?");
    //$stmt->bind_param("i", $user_id);

//    foreach ($details as $detail) {
//        echo $detail;
//    }


    foreach ($details as $value) {

        $user_id = $value;
        $stmt->bind_param("i", $user_id);
        $stmt1->bind_param("i", $user_id);


        if (!$stmt->execute()) {

            $response = array('code' => 400, 'message' => 'Script failed','error'=> $stmt->error);
            $response = json_encode($response);
            die($response);
        }
        else
            {
                if (!$stmt1->execute()) {

                    $response = array('code' => 400, 'message' => 'Script failed','error'=> $stmt->error);
                    $response = json_encode($response);
                    die($response);
                }
                else
                {
                    //echo "done";
                }
        }

    }
    $stmt->close();
    $stmt1->close();
}













$mysqli->close();



?>