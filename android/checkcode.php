<?php
require 'php/setup.php';
$information = $_SESSION['user_info'];
$email = $_POST['email'];         
$code = $_POST['code'];
$name = $_POST['name'];
$photo =$_POST['photo'];

$sql ="SELECT * FROM signup_token where generated_for =" ."'" .$email ."' and " ." token = " ."'".$code ."' and " ." is_used = " ."'"."0" ."';";
//echo $sql;
$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	
    $sql = "UPDATE signup_token set is_used = 1 where generated_for = " ."'" .$email ."'";
	
    if ($conn->query($sql) === TRUE) {
		
		$insert_sql = "INSERT INTO users(email,user_name,photo) VALUES('$email','$name','$photo')";
		
		if ($conn->query($insert_sql) === TRUE) {
			
			$sql = "select user_id from users where email = '$email'";
			$result = $conn->query($sql);
			$row = $result->fetch_assoc();
			$id = $row['user_id'];
			$insert_points_table = "INSERT INTO user_points(user_id,points,	no_of_referrals_remaining) VALUES($id,0,10)";
			if ($conn->query($insert_points_table) === TRUE)
			{
				$insert_profile_table = "INSERT INTO user_profile(user_id, about_me, sports_activities, hobbies, favourite_places, neighbourhood, lived_since) 
				VALUES($id,null,null,null,null,null,null)";
					if ($conn->query($insert_profile_table) === TRUE)
						echo 'accountcreated';
			}
				
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
}
}
else
{
    echo 'codeerror';
}

?>