<?php

	$mysqli = new mysqli('127.0.0.1', 'omar', 'geekdom1100', 'todo_list');

	// Check for errors
	if ($mysqli->connect_errno) {
	    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	class InvalidInputException extends Exception {}

	// 4. Add additional functionality, such as a delete function
	// 5. Move all functions into a class
	// 6. Require the class document
	// 7. Test and debug after every step

	if (!empty($_POST['newitem'])) {
		$stmt = $mysqli->prepare("INSERT INTO task (content) VALUES (?)");
		$stmt->bind_param("s", $_POST['newitem']);
		$stmt->execute();
	}

	$result = $mysqli->query("SELECT content FROM task");	

	if (isset($_POST['remove'])) {
		$stmt = $mysqli->prepare("DELETE FROM task WHERE id = ?");
		$stmt->bind_param('i', $_GET['remove']);
		$stmt->execute();
	}

	$mysqli->close();

	var_dump($_POST);

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/css/todostyle.css" type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans|Oxygen|Roboto+Slab' rel='stylesheet' type='text/css'>
	<script src="/js/bootstrap.js"></script>
	<title>Todo List</title>
</head>
<body>
	<div>
		<h1>TODO List</h1>
		<a href="#" id="imgclick"><img src='img/do-all-things.png' width=200 height=150 class='img-rounded'></a>
	</div>
	<br>
	<div class='newitem'>
		<form method='POST' id='additem' action='todo.php'>
		<ul>
			<?php 

			try{
				if (isset($_POST['newitem']) && empty($_POST['newitem'])) {
					throw new InvalidInputException('No tasks were entered in the todo list. <strong>Please enter a task.</strong>');
				}

				if (isset($_POST['newitem']) && strlen($_POST['newitem']) > 240) {
					throw new InvalidInputException('Task is longer than 240 characters. <strong>Please make it shorter.</strong>');
				}
			} catch (InvalidInputException $e) {
				echo $e->getMessage();
			}

			while ($row = $result->fetch_array(MYSQLI_NUM)) {
				foreach ($row as $key => $task) {
					echo "<li>" . htmlspecialchars(strip_tags($task)) . ' ' . "<button class='btn btn-danger' onclick='removebyID($key)'><span class='glyphicon glyphicon-ok-circle'></span></button></li>";
				}
			}
			
			?>
		</ul>
	    	<script>
		    	var form = document.getElementById('removeForm');
		    	var removeID = document.getElementById('removeID');

		    	function removebyID(id) {
		    		removeID.value = id;
		    		form.submit();
		    	}
		    </script>
		<br>
			<p>
				<label for='newitem'>Task: </label>
				<input id='newitem' name='newitem' type='text' placeholder='Enter task' autofocus='autofocus'>
			</p>
			<p>
				<button id='newitem' class="btn btn-primary" type="submit">Add todo</button>
			</p>
		</form>
		<form method="POST" id="removeForm" action="todo.php">
	    	<input id="removeID" type="hidden" name="remove" value="">
	    </form>
	</div>
	<div>
		<footer>
			<p class='trademark'>&copy; 2014 <a href="www.writtenbyapanda.com" target="_blank">Written by a Panda</a></p>
		</footer>
	</div>
</body>
</html>