<?php
//include 'php/setup.php';
include("php".DIRECTORY_SEPARATOR."setup.php");

//$obj = json_decode('{to_call:get_post_data}');
/*
challenge_info:
{
    "to_call": "get_my_active_challenges_data"	
}

*/


$obj = json_decode($_POST['no_of_referral']);
//$obj = 2;
$referral_worth = 5; //change points for 1 referral 
$points = $obj * $referral_worth;

//echo $to_call;
session_start();
$user_id = $_SESSION['user_id'];
//$user_id = 28;

	 $get_status = ORM::for_table('user_points')->raw_query('
		Select * from user_points where user_id = :user_id and points >= :points', 
		array('user_id' => $user_id, 'points' => $points))->find_one();
		
		if($get_status != null){
			
			$new_points = ($get_status->points) - $points;
			$new_referral = ($get_status->no_of_referrals_remaining) + $obj;
		
			$mysqli = new mysqli($host, $user, $pass, $database);
			$stmt = $mysqli->prepare("UPDATE user_points SET points = ".$new_points .", no_of_referrals_remaining 
			= ". $new_referral ." WHERE user_id = ". $user_id);

			if (!$stmt->execute()) {
			header('location: redeem.php?error=serverdown');
			die($response);
		} else {
			 header('location: redeem.php?error=success');
		}
		$stmt->close();
		}
		else{
		header('location: redeem.php?error=unsuccessful');
	}
	
	

?>