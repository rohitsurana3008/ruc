<?php
header("Access-Control-Allow-Origin: *");
include("php".DIRECTORY_SEPARATOR."setup.php");
$user_id = $_REQUEST['user_id'];

$get_id_query = ORM::for_table('(Select x.*, y.about_me, y.sports_activities, y.hobbies, y.favourite_places, y.neighbourhood, y.lived_since from users x, user_profile y where x.user_id = y.user_id)')->raw_query('Select x.*, y.about_me, y.sports_activities, y.hobbies, y.favourite_places, y.neighbourhood, y.lived_since from users x, user_profile y where x.user_id = y.user_id and x.user_id = :userid', array('userid' => $user_id))->find_one();
 if($get_id_query){
		$obj_to_send = new \stdClass();
        $obj_to_send->user_id = $get_id_query->user_id;
        $obj_to_send->user_name = $get_id_query->user_name;
        $obj_to_send->user_img = $get_id_query->photo;
        $obj_to_send->about_me = $get_id_query->about_me;
        $obj_to_send->sports_activities = $get_id_query->sports_activities;
        $obj_to_send->hobbies = $get_id_query->hobbies;
        $obj_to_send->favourite_places = $get_id_query->favourite_places;
        $obj_to_send->neighbourhood = $get_id_query->neighbourhood;
        $obj_to_send->lived_since = $get_id_query->lived_since;
    }
    $get_id_query_points = ORM::for_table('user_points')->where('user_id', $user_id)->find_one();
        if($get_id_query_points){
            $obj_to_send->points = $get_id_query_points->points;
            
            $get_id_query_badges = ORM::for_table('user_badges')->raw_query('SELECT a.*,b.badge_photo FROM user_badges a JOIN badges_info b ON a.badge_id = b.badge_id WHERE a.user_id = :userid', array('userid' => $user_id))->find_many();
            $myArr = array();
            $counter = 0;
            foreach ($get_id_query_badges as $user_badge_info) {
                $myArr[$counter++] = $user_badge_info->badge_photo;
            }
            
        }
  $obj_to_send->badges = $myArr;
  $myJSON = json_encode($obj_to_send);
            echo $myJSON;



?>