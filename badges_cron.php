<?php
include("php".DIRECTORY_SEPARATOR."setup.php");

$mysqli = new mysqli($host, $user, $pass, $database);

if (!$mysqli->query("CALL badges_adder()")) {
    echo "CALL failed: (" . $mysqli->errno . ") " . $mysqli->error;
}
?>