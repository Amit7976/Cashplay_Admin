<?php
$servername = "127.0.0.1:3306";
$username = "u747617934_amit_root";
$password = "2:nZ6F7G$";
$db = "u747617934_test_cahplay";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
