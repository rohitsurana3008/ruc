<?php
include "php/setup.php";
$email = $_POST["email"];
// Create connection
$conn = new mysqli($host, $user, $pass, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$sql = "select user_id,user_name,photo from users where email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
	$row = $result->fetch_assoc();
	$userid = $row["user_id"];
	$name = $row["user_name"];
	$photo = $row["photo"];
	$get_id_query = ORM::for_table('user_profile')->where('user_id', $userid)->find_one();
    $get_points_query = ORM::for_table('user_points')->where('user_id', $userid)->find_one();
	
    if($get_id_query){
		$obj_to_send = new \stdClass();
        $obj_to_send->user_id = $get_id_query->user_id;
		$obj_to_send->name = $name;
		$obj_to_send->photo = $photo;
        $obj_to_send->about_me = $get_id_query->about_me;
        $obj_to_send->sports_activities = $get_id_query->sports_activities;
        $obj_to_send->hobbies = $get_id_query->hobbies;
        $obj_to_send->favourite_places = $get_id_query->favourite_places;
        $obj_to_send->neighbourhood = $get_id_query->neighbourhood;
        $obj_to_send->lived_since = $get_id_query->lived_since;
		$obj_to_send->points = $get_points_query->points;
		$myJSON = json_encode($obj_to_send);
     echo $myJSON;
	}
} 
else {
    echo "failed";
}
$conn->close();
?>