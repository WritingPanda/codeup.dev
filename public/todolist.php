<?php

echo "<p>POST:</p>";
var_dump($_POST);

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todo List</title>
</head>
<body>
	<h1>TODO List</h1>
	<ul>
		<li>Go to the bank</li>
		<li>Pay bills</li>
		<li>Go grocery shopping</li>
		<li>Feed the dogs</li>
	</ul>
	
	<h2>Add todos to the list</h2>
	<form method="POST" action="">
		<p>
			<label for="todo">Task: </label>
			<input id="todo" name="todo" type="text" placeholder="Enter task">
		</p>
		<p>
			<button type="submit">Add todo</button>
		</p>
	</form>
</body>
</html>