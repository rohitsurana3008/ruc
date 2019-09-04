<?php
//include 'php/setup.php';
include("php".DIRECTORY_SEPARATOR."setup.php");

session_start();
$user_id = $_SESSION['user_id'];

$obj = json_decode($_POST['profile_info']);
$to_call = $obj->to_call;

function get_data($obj_temp, $user_id_temp){
    $get_id_query = ORM::for_table('user_profile')->where('user_id', $user_id_temp)->find_one();
    
    if($get_id_query){
		$obj_to_send = new \stdClass();
        $obj_to_send->user_id = $get_id_query->user_id;
        $obj_to_send->about_me = $get_id_query->about_me;
        $obj_to_send->sports_activities = $get_id_query->sports_activities;
        $obj_to_send->hobbies = $get_id_query->hobbies;
        $obj_to_send->favourite_places = $get_id_query->favourite_places;
        $obj_to_send->neighbourhood = $get_id_query->neighbourhood;
        $obj_to_send->lived_since = $get_id_query->lived_since;
        
        //echo json_encode($obj_to_send);
        
        $get_id_query_points = ORM::for_table('user_points')->where('user_id', $user_id_temp)->find_one();
        if($get_id_query_points){
            $obj_to_send->points = $get_id_query_points->points;
            
            $get_id_query_badges = ORM::for_table('user_badges')->raw_query('SELECT a.*,b.badge_photo FROM user_badges a JOIN badges_info b ON a.badge_id = b.badge_id WHERE a.user_id = :userid', array('userid' => $user_id_temp))->find_many();
            $myArr = array();
            $counter = 0;
            foreach ($get_id_query_badges as $user_badge_info) {
                $myArr[$counter++] = $user_badge_info->badge_photo;
            }
            
            $obj_to_send->badges = $myArr;
            $myJSON = json_encode($obj_to_send);
            echo $myJSON;
        }
    }
}

function update_data($obj_temp, $user_id_temp){
	$profile = ORM::for_table('user_profile')->where('user_id', $user_id_temp)->find_one();
	$profile->about_me = $obj_temp->about_me;
	$profile->sports_activities = $obj_temp->sports_activities;
	$profile->hobbies = $obj_temp->hobbies;
	$profile->favourite_places = $obj_temp->favourite_places;
	$profile->neighbourhood = $obj_temp->neighbourhood;
	$profile->lived_since = $obj_temp->lived_since;
	$profile->save();
	
	$obj_to_send = new \stdClass();
	$obj_to_send->result = "success";
	$myJSON = json_encode($obj_to_send);
	echo $myJSON;
}

function generate_code($obj_temp, $user_id_temp,$host_t, $user_t, $pass_t, $database_t){
	$generated_for_email_id = $obj_temp->email_id;
	$person = ORM::for_table('users')->where('email', $generated_for_email_id)->find_one();
	$obj_to_send = new \stdClass();
	if($person){
		$obj_to_send->email_id = $generated_for_email_id;
		$obj_to_send->result = "unsuccess";
		$obj_to_send->result_code = 201;
		$myJSON = json_encode($obj_to_send);
		echo $myJSON;
	}else{
		$generated_for_check = ORM::for_table('signup_token')->where_raw('(genreated_by = ? and generated_for = ?)', array($user_id_temp, $generated_for_email_id))->find_one();
		
		if($generated_for_check){
			$obj_to_send->email_id = $generated_for_email_id;
			$obj_to_send->result = "unsuccess";
			$obj_to_send->result_code = 202;
			$myJSON = json_encode($obj_to_send);
			echo $myJSON;
		}else{
			$letters='abcdefghijklmnopqrstuvwxyz';  // selection of a-z
			$string='';  // declare empty string
			for($x=0; $x<3; ++$x){  // loop three times
				$string.=$letters[rand(0,25)].rand(0,9);  // concatenate one letter then one number
			}
					
			$conn = new mysqli($host_t, $user_t, $pass_t, $database_t);
			if(!$conn->connect_error)
			{
				$stmt = $conn->prepare("INSERT INTO signup_token (token,genreated_by,generated_for) VALUES (?,?,?)");
				$stmt->bind_param("sis", $string, $user_id_temp, $generated_for_email_id);
				$stmt->execute();
				$stmt->close();
				$conn->close();
	
				$obj_to_send->email_id = $generated_for_email_id;
				$obj_to_send->generated_code = $string;
				$obj_to_send->result = "success";
				$obj_to_send->result_code = 100;
				$myJSON = json_encode($obj_to_send);
				echo $myJSON;
			}
			else{
				$obj_to_send->email_id = $generated_for_email_id;
				$obj_to_send->result = "unsuccess";
				$obj_to_send->result_code = 200;
				$myJSON = json_encode($obj_to_send);
				echo $myJSON;
			}
		}
	}
}

function get_generated_codes($obj_temp, $user_id_temp){
	$generated_for_email_id = $obj_temp->email_id;
	$get_all_generated_codes = ORM::for_table('signup_token')->raw_query('SELECT * FROM signup_token WHERE genreated_by = :genreatedby and is_used = 0', array('genreatedby' => $user_id_temp))->find_many();
    $obj_to_send = new \stdClass();
	$obj_to_send->result = "success";
	$obj_to_send->result_code = 100;
	$myArr = array();
    $counter = 0;
    foreach ($get_all_generated_codes as $all_codes) {
		$obj_to = new \stdClass();
		$obj_to->email = $all_codes->generated_for;
		$obj_to->token = $all_codes->token;
		$myArr[$counter++] = $obj_to;
        //$myArr[$counter++] = $all_codes->generated_for.'#'.$all_codes->token;
    }
	$obj_to_send->generated_codes = $myArr;
    $myJSON = json_encode($obj_to_send);
    echo $myJSON;
}

switch ($to_call) {
    case "update_data":
        update_data($obj, $user_id);
        break;
    case "get_data":
        get_data($obj, $user_id);
        break;
	case "generate_code":
        generate_code($obj, $user_id,$host, $user, $pass, $database);
        break;
	case "get_generated_codes":
        get_generated_codes($obj, $user_id,$host, $user, $pass, $database);
        break;
    default:
        echo 'no method';
}

?>