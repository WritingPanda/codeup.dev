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

if (count($_FILES) > 0 && $_FILES['upload']['error'] == 0 && $_FILES['upload']['type'] == 'text/plain') {
	$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
	$filename = basename($_FILES['upload']['name']);
	$saved_filename = $upload_dir . $filename;
	move_uploaded_file($_FILES['upload']['tmp_name'], $saved_filename);
}

?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Todo List</title>
</head>
<body>
	<h1>TODO List</h1>
	<img src='img/do-all-things.png' width=200 height=150>

	<form method='POST' enctype='multipart/form-data' action='todolist.php'>
	<ul>
		<?php 

		$items = read_file('data/todo_list.txt');

		if (!empty($_POST['newitem'])) {
			$newItem = $_POST['newitem'];
			array_push($items, $newItem);
			save_file('data/todo_list.txt', $items);
			header('Location: todolist.php');
			exit(0);
		}

		if (!empty($_FILES['upload']) && $_FILES['upload']['type'] == 'text/plain') {
			$newFileArray = read_file("/vagrant/sites/codeup.dev/public/uploads/{$filename}");
			$combineArray = array_merge($items, $newFileArray);
			save_file('data/todo_list.txt', $combineArray);
			header('Location: todolist.php');
			exit(0);
		} elseif (count($_FILES) > 0 && $_FILES['upload']['type'] != 'text/plain') {
			echo "<p><strong>ERROR:</strong> File is not a txt file.</p>";
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
		<p>
			<label for='newitem'>Task: </label>
			<input id='newitem' name='newitem' type='text' placeholder='Enter task' autofocus='autofocus'>
		</p>
		<p>
			<label for='upload'>Upload a file to add to the list: </label>
			<input id='upload' name='upload' type='file'>
		</p>
		<p>
			<button type='submit'>Add todo</button>
		</p>
	</form>

</body>
</html>