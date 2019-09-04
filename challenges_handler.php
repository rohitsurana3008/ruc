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


$obj = json_decode($_POST['challenge_info']);
$to_call = $obj->to_call;

//echo $to_call;
session_start();
$user_id = $_SESSION['user_id'];
//$user_id = 28;

function get_view_challenges_data($obj_temp, $user_id_temp){
    $get_posts = ORM::for_table('user_challenges')->raw_query('
		Select a.*,b.user_name,b.photo from user_challenges a, users b where a.creator_user_id <> :userid and a.is_accepted = 0 
		and a.creator_user_id = b.user_id', 
		array('userid' => $user_id_temp))->find_many();
    
	$obj_to_send = new \stdClass();
	$myArr = array();
    $counter = 0;
	
    foreach ($get_posts as $post_info) {
		$post_to_send = new \stdClass();
		$post_to_send->challenge_id = $post_info->challenge_id;
		$post_to_send->desc_text = $post_info->desc_text;
		$post_to_send->points = $post_info->points;
		$post_to_send->duration = $post_info->duration;
		$post_to_send->created_at = $post_info->created_at;
		$post_to_send->challenge_by = $post_info->user_name;
		$post_to_send->photo = $post_info->photo;
        $myArr[$counter++] = $post_to_send;
    }
    	
    $obj_to_send->challenges = $myArr;
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;	      
}

function put_accept_challenges_data($obj_temp, $user_id_temp, $host_t, $user_t, $pass_t, $database_t){
	 $get_status = ORM::for_table('user_challenges')->raw_query('
		Select * from user_challenges where challenge_id = :challengeid and is_accepted = 0', 
		array('challengeid' => $obj_temp->challenge_id))->find_one();
		
	$obj_to_send = new \stdClass();
	if($get_status){
		
		$mysqli = new mysqli($host_t, $user_t, $pass_t, $database_t);
		$stmt = $mysqli->prepare("UPDATE user_challenges SET is_accepted = 1 WHERE challenge_id=?");
		$stmt->bind_param("i",$obj_temp->challenge_id);
		
		if (!$stmt->execute()) {
			$obj_to_send->result = 'unsuccess';
			$obj_to_send->result_code = '400';	
			$obj_to_send->result_message= 'Server Down';
		} else {
			$stmt->close();
			$profile = ORM::for_table('accepted_challenges')->create();
			$profile->challenge_id = $obj_temp->challenge_id;
			$profile->accepted_user_id = $user_id_temp;
			
			$now = time();
			$ten_minutes = $now + ($get_status->duration * 60);
			$endDate = date('Y-m-d H:i:s', $ten_minutes);
			// echo $endDate;
			$profile->end_at = $endDate;
			$profile->is_approved = 0;
			$profile->active = 1;
			$profile->save();
		
			$obj_to_send->result = 'success';
			$obj_to_send->result_code = '100';
		}	
	}else{
		$obj_to_send->result = 'unsuccess';
		$obj_to_send->result_code = '400';	
		$obj_to_send->result_message= 'Challenge already accepted';			
	}
	$myJSON = json_encode($obj_to_send);
	echo $myJSON;
}

function get_my_active_challenges_data($obj_temp, $user_id_temp){
    $get_posts = ORM::for_table('accepted_challenges')->raw_query('
		Select a.*, b.desc_text, b.points, c.user_name, c.photo from accepted_challenges a,user_challenges b, users c where a.accepted_user_id = :userid and 
		a.is_approved = 0 and a.active = 1 and a.challenge_id = b.challenge_id and 
		b.creator_user_id = c.user_id', 
		array('userid' => $user_id_temp))->find_many();
    
	$obj_to_send = new \stdClass();
	$myArr = array();
    $counter = 0;
	
    foreach ($get_posts as $post_info) {
		$post_to_send = new \stdClass();
		$post_to_send->challenge_id = $post_info->challenge_id;
		$post_to_send->desc_text = $post_info->desc_text;
		$post_to_send->points = $post_info->points;
		$post_to_send->challenge_by = $post_info->user_name;
		$post_to_send->photo = $post_info->photo;
		$post_to_send->end_at = $post_info->end_at;
        $myArr[$counter++] = $post_to_send;
    }
	$obj_to_send->result = 'success';
	$obj_to_send->result_code = '100';
    $obj_to_send->challenges = $myArr;
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;	      
}

switch ($to_call) {
    case "get_view_challenges_data":
        get_view_challenges_data($obj, $user_id);
    break;
	case "put_accept_challenges_data":
        put_accept_challenges_data($obj, $user_id, $host, $user, $pass, $database);
    break;
	case "get_my_active_challenges_data":
        get_my_active_challenges_data($obj, $user_id);
    break;
    default:
        echo 'no method';
}

?>