<?php
include "php/setup.php";
$email = $_POST["email"];
// Create connection
$conn = new mysqli($host, $user, $pass, $database);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "select user_id from users where email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$userid = $row["user_id"];
	
	$profile = ORM::for_table('user_profile')->where('user_id', $userid)->find_one();
	$profile->about_me = $_POST["about_me"];
	$profile->sports_activities = $_POST["sports_activities"];
	$profile->hobbies = $_POST["hobbies"];
	$profile->favourite_places = $_POST["favourite_places"];
	$profile->neighbourhood = $_POST["neighbourhood"];
	$profile->lived_since = $_POST["lived_since"];
	$profile->save();
    echo "success";
} else {
    echo "failed";
}
$conn->close();
?>
