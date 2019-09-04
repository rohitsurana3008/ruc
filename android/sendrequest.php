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

$stmt = $conn->prepare("INSERT INTO requests (user_email, user_name, user_contact) VALUES (?, ?,?)");
$stmt->bind_param("sss", $email, $name, $contact);

$email = $_POST["email"];
$name = $_POST["name"];
$contact = $_POST["contact"];

if ($stmt->execute()) {
    echo "requestsent";
} else {
    echo "requestsendingfailed";
}
$stmt->close();
$conn->close();
?>