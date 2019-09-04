<?php
include "php/setup.php";

$user_id = 1;//$_SESSION['user_id'];
$approve_user = 17;
$points = 1;
$challenge_id = 2;

/*
$conn2 = new mysqli($host, $user, $pass, $database);

if ($conn2->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT active from active_challenges where challenge_id = $challenge_id";
$result = $conn2->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		if(row["active"] == 1)
			echo 'failed';
		else{
			echo 'done1';
		}
    }
} else {
    echo "0 results";
}




*/
$conn = new mysqli($host, $user, $pass, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "UPDATE user_points SET points = points - $points where user_id = $user_id";

if ($conn->query($sql) === TRUE) {
	
			
			$conn1 = new mysqli($host, $user, $pass, $database);

		if ($conn1->connect_error) {
			die("Connection failed: " . $conn1->connect_error);
		} 

		$sql = "UPDATE user_points SET points = points + $points where user_id = $approve_user";

		if ($conn1->query($sql) === TRUE) {
			echo 'success';
		} else {
			
		}
		$conn1->close();
		
	
	
} else {
    
}
$conn->close();
?>