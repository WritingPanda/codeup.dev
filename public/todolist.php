<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todo List</title>
</head>
<body>
	<h1>TODO List</h1>

	<h2>Add todos to the list</h2>
	<form method='POST' action='todolist.php'>

		<p>
			<label for='newitem'>Task: </label>
			<input id='newitem' name='newitem' type='text' placeholder='Enter task' autofocus='autofocus'>
		</p>
		<p>
			<button type='submit'>Add todo</button>
		</p>
	</form>
	<ul>
		<?php 

		function read_file($filename) {
		    $handle = fopen($filename, "r");
		    $size = filesize($filename);
		    if ($size == 0) {
		    	echo "You don't have any tasks! Nice!";
		    	echo "<p>Add some tasks!</p>";
		    	return $items = [];
		    }
		    $contents = fread($handle, $size);
		    $contents_array = explode("\n", $contents);
		    fclose($handle);
		    return $contents_array;
		}

		function save_file($filename, $data_to_save) {
			$handle = fopen($filename, 'w');
        	$contents = implode("\n", $data_to_save);
        	fwrite($handle, $contents);
        	fclose($handle);
		}

		$items = read_file('data/todo_list.txt');

		if (!empty($_POST['newitem'])) {
			$newItem = $_POST['newitem'];
			array_push($items, $newItem);
			save_file('data/todo_list.txt', $items);
			header('Location: todolist.php');
			exit(0);
		}

		foreach ($items as $key => $item) {
			echo "<li>{$item} | <a href='?remove={$key}'>Complete</a></li>";
		
		} 
			if (isset($_GET['remove'])) {
				$key = $_GET['remove'];
				unset($items[$key]);
				save_file('data/todo_list.txt', $items);
				header('Location: todolist.php');
				exit(0);
			}
		?>
	</ul>
</body>
</html>