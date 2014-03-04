<?php

require_once('classes/filestore.php');

class InvalidInputException extends Exception {}

class TodoDataStore extends Filestore {
	public function read_lines() {
		$size = filesize($this->filename);
        if ($size == 0) {
            echo "<p>You don't have any tasks! Nice!</p>";
            echo "<p>Add some tasks!</p>";
            return $items = [];
        }
        return parent::read_lines();
	}
}

$todo = new TodoDataStore('data/todo_list.txt');

if (count($_FILES) > 0 && $_FILES['upload']['error'] == 0 && $_FILES['upload']['type'] == 'text/plain') {
	$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
	$Newfilename = basename($_FILES['upload']['name']);
	$saved_filename = $upload_dir . $Newfilename;
	move_uploaded_file($_FILES['upload']['tmp_name'], $saved_filename);
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/resources/addressbookstyle.css">
	<title>Todo List</title>
</head>
<body>
	<h1>TODO List</h1>
	<img src='img/do-all-things.png' width=200 height=150>

	<form method='POST' action='todolist.php'>
	<ul>
		<?php 

		$items = $todo->read();
		try{
			if (isset($_POST['newitem']) && empty($_POST['newitem'])) {
				throw new InvalidInputException('No tasks were entered in the todo list. <strong>Please enter a task.</strong>');
			}

			if (isset($_POST['newitem']) && strlen($_POST['newitem']) > 240) {
				throw new InvalidInputException('Task is longer than 240 characters. <strong>Please make it shorter.</strong>');
			}
			if (!empty($_POST['newitem'])) {
				$newItem = $_POST['newitem'];
				array_push($items, $newItem);
				$todo->write($items);
				header('Location: todolist.php');
				exit(0);
			}
		} catch (InvalidInputException $e) {
			echo $e->getMessage();
		}

		if (!empty($_FILES['upload']) && $_FILES['upload']['type'] == 'text/plain') {
			$todo->filename = "/vagrant/sites/codeup.dev/public/uploads/{$Newfilename}";
			$newFileArray = $todo->read();
			$combineArray = array_merge($items, $newFileArray);
			$todo->filename = 'data/todo_list.txt';
			$todo->write($combineArray);
			header('Location: todolist.php');
			exit(0);
		} elseif (count($_FILES) > 0 && $_FILES['upload']['type'] != 'text/plain') {
			echo "<p><strong>ERROR:</strong> File is not a txt file.</p>";
		}

		foreach ($items as $key => $item) {
			echo "<li>" . htmlspecialchars(strip_tags($item)) . " | <a href='?remove={$key}'>Complete</a></li>";
		
		}

		if (isset($_GET['remove'])) {
			$key = $_GET['remove'];
			unset($items[$key]);
			$todo->write($items);
			header('Location: todolist.php');
			exit(0);
		}
		
		?>
	</ul>
		<p>
			<label for='newitem'>Task: </label>
			<input id='newitem' name='newitem' type='text' placeholder='Enter task' autofocus='autofocus'>
		</p>
		<p>
			<button type='submit'>Add todo</button>
		</p>
	</form>
	<form method='POST' enctype='multipart/form-data' action='todolist.php'>
		<p>
			<label for='upload'>Upload a file to add to the list: </label>
			<input id='upload' name='upload' type='file'>
		</p>
		<p>
			<button type='submit'>Upload</button>
		</p>

	</form>
	<footer>
		<p style="font-family:Courier">&copy; 2014 <a href="http://writtenbyapanda.tumblr.com" target="_blank">Written by a Panda</a></p>
	</footer>
</body>
</html>