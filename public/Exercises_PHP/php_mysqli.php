<?php 

$mysqli = @new mysqli('127.0.0.1', 'WritingPanda', '**************', 'codeup_mysqli_test_db');

if ($mysqli->connect_errno) {
	echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
} else {
	echo $mysqli->host_info . PHP_EOL;	
}

echo "Hello, Omar. Welcome to the lesson.";
?>