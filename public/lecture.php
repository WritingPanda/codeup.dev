<?php

echo "<p>POST:</p>";
var_dump($_POST);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Lecture notes</title>
</head>
<body>

<h1>Login Form</h1>

<?php 

	session_start();

	$username = 'codeup';
	$password = 'letmein';

	if ($_GET['logout'] == TRUE) {
		$_SESSION = array();
		session_destroy();
		header("Location: lecture.php");
	}

	if (!empty($_POST)) {
		if ($_POST['username'] == $username && $_POST['password'] == $password)
			$_SESSION['logged in'] = TRUE;
	}

	var_dump($_COOKIE);
	var_dump($_SESSION);

	if ($_SESSION['logged in'] == TRUE) {
		echo "<p>You are logged in.</p>";
		echo "<p><a href='lecture.php?logout=true'>Log out</a></p>";
	} else {

    // foreach($_POST as $key => $value) {
    //     echo "<p>{$key} => ${value}</p>";
    // }
?>

<form method="POST" action="">
    <p>
        <label for="username">Username</label>
        <input id="username" name="username" type="text">
    </p>
    <p>
        <label for="password">Password</label>
        <input id="password" name="password" type="password">
    </p>
    <p>
        <input type="submit">
    </p>
</form>

<?php } ?>

</body>
</html>