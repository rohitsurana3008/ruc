<?php 
 include "php/setup.php";
 session_start();
 $user_id = $_SESSION['user_id'];
 if($user_id == null || $user_id = "")
 {
 	header('location: index.php');
 }
$information = $_SESSION['user_info'];
$email = $information['email'];         

$code = $_POST['code'];
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
        
        $person = ORM::for_table('users')->create();
			
		
		// Set the properties that are to be inserted in the db
		$person->email = $information['email'];
		$person->user_name = $information['name'];
		
		if(isset($information['picture'])){
			// If the user has set a public google account photo
			$person->photo = $information['picture'];
		}
		else{
			// otherwise use the default
			$person->photo = 'assets/img/default_avatar.jpg';
		}
		
		// insert the record to the database
		$person->save();
		
		$get_id_query = ORM::for_table('users')->where('email', $email)->find_one();
		
		if($get_id_query)
		{
		    $profile = ORM::for_table('user_profile')->create();
		    //echo $get_id_query->refered_by;
		    $profile->user_id = $get_id_query->id();
		    $profile->about_me = NULL;
		    $profile->sports_activities = NULL;
		    $profile->hobbies = NULL;
		    $profile->favourite_places = NULL;
		    $profile->neighbourhood = NULL;
		    $profile->lived_since = NULL;
		    $profile->save();
			
			$points = ORM::for_table('user_points')->create();
			$points->user_id = $get_id_query->id();
			$points->points = 0;
			$points->save();
			session_start();
			$_SESSION['user_id'] = $get_id_query->id();
			$_SESSION['user_name'] = $get_id_query->user_name;
			$_SESSION['user_email'] = $get_id_query->email;
			$_SESSION['user_photo'] = $get_id_query->photo;
			
		    header("Location: $redirect_url_home");
		}
    }
}
else
{
    header("Location: $redirect_url_codeverify?message=invalid_code");
}

?>