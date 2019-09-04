<?php
$servername = "rucdb.atown.dreamhosters.com";
$username = "rucdbuser";
$password = "rucDB9ass";
$dbname = "ruconncdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
$email = $_POST["email"];
$sql = "SELECT user_id FROM users where email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
    echo 'userpresent';
} 
else 
{
    echo 'usernotpresent';
}
$conn->close();
?>