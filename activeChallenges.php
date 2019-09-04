<?php
include "php/setup.php";
session_start();
$user_id = $_SESSION['user_id'];
// Create connection
$conn = new mysqli($host, $user, $pass, $database);
$conn1 = new mysqli($host, $user, $pass, $database);

$obj_to_send = new \stdClass();

$myArr = array();
$counter = 0;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else
{
	$stmt = $conn->prepare("SELECT challenge_id, desc_text, points, duration, is_accepted, created_at from user_challenges where creator_user_id = ?");
	$stmt->bind_param("i", $user_id);
	
	$stmt->execute();
	
	$challenge_id = 'challenge_id';
	$desc_text = 'desc_text';
	$points = 'points';
	$duration = 'duration';
	$is_accepted = 'is_accepted';
	$created_at = 'created_at';
	
	$stmt->bind_result($challenge_id, $desc_text,$points, $duration,$is_accepted, $created_at);
	
	while ($stmt->fetch()) {
		$all_user_challenges = new \stdClass();
		$all_user_challenges->challenge_id = $challenge_id;
		$all_user_challenges->desc_text = $desc_text;
		$all_user_challenges->points = $points;
		$all_user_challenges->duration = $duration;
		$all_user_challenges->is_accepted = $is_accepted;
		$all_user_challenges->created_at = $created_at;
		
		$all_user_challenges->accepted_user_id = null;
		$all_user_challenges->end_at = null;
		$all_user_challenges->is_approved = null;
		$all_user_challenges->active = null;
		
		
		$stmt1 = $conn1->prepare("SELECT accepted_user_id, end_at, is_approved, active from accepted_challenges where challenge_id = ?");
		$stmt1->bind_param("i", $challenge_id);
		$stmt1->execute();
		
		$a = 'accepted_user_id';
		$e = 'end_at';
		$i = 'is_approved';
		$act = 'active';
		
		$stmt1->bind_result($a,$e, $i,$act);
		
		while($stmt1->fetch())
		{
			$all_user_challenges->accepted_user_id = $a;
			$all_user_challenges->end_at = $e;
			$all_user_challenges->is_approved =  $i;
			$all_user_challenges->active = $act;
		}
		$myArr[$counter++] = $all_user_challenges;
		
	}
}
	$obj_to_send->all_challenges = $myArr;
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;	      
	$conn->close();
	$conn1->close();
?>