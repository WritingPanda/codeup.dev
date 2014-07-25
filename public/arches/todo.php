<?php

	$errormsg = NULL;
	$successmsg = NULL;

	// connect to the db
	$mysqli = new mysqli('127.0.0.1', '***', '****', 'todo_list');

	// Check for errors
	if ($mysqli->connect_errno) {
	    throw new Exception('Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
	}

	if (!empty($_POST)) {
		if (isset($_POST['todo'])) {
			if (!empty($_POST['todo']) != "") {
				$todo = substr($_POST['todo'], 0, 200);
				// add to db
				$stmt = $mysqli->prepare("INSERT INTO todos (item) VALUES (?);");
				$stmt->bind_param("s", $todo);
				$stmt->execute();

				$successmsg = "Todo item was added successfully!";
			} else {
				$errormsg = "Please enter a todo item.";
			}
		} elseif (!empty($_POST['remove'])) {
			// remove item from DB
			$stmt = $mysqli->prepare("DELETE FROM todos WHERE id = ?;");
			$stmt->bind_param("i", $_POST['remove']);
			$stmt->execute();

			$successmsg = "Todo item was removed successfully.";
		}
	}

	$itemsPerPage = 5;
	$currentPage = !empty($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
	$offset = ($currentPage - 1) * $itemsPerPage;

	$todos = $mysqli->query("SELECT * FROM todos LIMIT $itemsPerPage OFFSET $offset;");
	$allTodos = $mysqli->query("SELECT * FROM todos;");

	$maxPage = ceil($allTodos->num_rows / $itemsPerPage);

	$prevPage = $currentPage > 1 ? $currentPage - 1 : null;
	$nextPage = $currentPage < $maxPage ? $currentPage + 1 : null;

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="/css/superhero-bootstrap.css">
	<link rel="stylesheet" href="/css/todostyle.css" type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans|Oxygen|Roboto+Slab' rel='stylesheet' type='text/css'>
	<script src="/js/bootstrap.js"></script>
	<title>Do All the Things</title>
</head>
<body>
	<div class="container">
		<? if (!empty($successmsg)): ?>
			<div class='alert alert-success'><?= $successmsg; ?></div>
		<? endif; ?>
		<? if (!empty($errormsg)): ?>
			<div class='alert alert-danger'><?= $errormsg; ?></div>
		<? endif; ?>

	<div class='center-block'>
		<h1>TODO List</h1>
		<a href="#" id="imgclick"><img src='img/do-all-things.png' width=200 height=150 class='img-rounded'></a>
	</div>
	<br>
		<table class="table">
		<? while ($todo = $todos->fetch_assoc()): ?>
			<tr>
				<td><?= $todo['item']; ?></td>
				<td><button class="btn btn-danger btn-sm pull-left" onclick="removeById(<?= $todo['id']; ?>)">Remove</button></td>
			</tr>
		<? endwhile; ?>
		</table>

		<? if ($prevPage != null): ?>
			<a class="pull-left btn btn-default" href="?page=<?= $prevPage; ?>">&lt; Previous</a>
		<? endif; ?>
		
		<? if ($nextPage != null): ?>
			<a class="pull-left btn btn-default" href="?page=<?= $nextPage; ?>">Next &gt;</a>
		<? endif; ?>
		<br>
		<div id='add-items'>
			<h2>Add Items</h2>
			<form class="form-inline" role="form" action="todo.php" method="POST">
				<div class="form-group has-error">
					<label class="sr-only" for="exampleInputEmail2">Todo Item</label>
					<input type="text" name="todo" class="form-control" placeholder="Enter todo item" autofocus='autofocus'>
				</div>
				<button type="submit" class="btn btn-default">Add Todo</button>
			</form>
		</div>
	</div>
	<form id="removeForm" action="todo.php" method="post">
		<input id="removeId" type="hidden" name="remove" value="">
	</form>
	<br>
		<footer>
			<p class='trademark'>&copy; 2014 <a href="www.writtenbyapanda.com" target="_blank">Written by a Panda</a></p>
		</footer>
	</div>
	<script>
		
		var form = document.getElementById('removeForm');
		var removeId = document.getElementById('removeId');

		function removeById(id) {
			if (confirm('Are you sure you want to remove item ' + id + '?')) {
				removeId.value = id;
				form.submit();
			}
		}

	</script>
</body>
</html>