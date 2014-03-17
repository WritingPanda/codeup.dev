<?php 

	$mysqli = new mysqli('127.0.0.1', 'omar', 'geekdom1100', 'codeup_mysqli_test_db');

	// Check for errors
	if ($mysqli->connect_errno) {
	    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

?>