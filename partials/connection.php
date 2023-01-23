<?php 

$db_host = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "nea";


$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
  }

?>
