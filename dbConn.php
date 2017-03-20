<?php 

	$servername = "localhost";
	$username = "YourUsernameHere";
	$password = "yourPasswordHere";
	$dbname = "YourDBnameHere";

	// Create connection$_SESSION['valid_user'] = $user;$_SESSION['valid_user'] = $user;
	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
?>
