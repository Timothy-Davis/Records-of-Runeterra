<?php
//connect.php
$server = 'localhost';
$username   = 'tim';
$password   = 'a';
$database   = 'ror_forum';
 
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
}
?>