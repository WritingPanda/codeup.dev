<?php 

$todoList = [
	'take out the trash',
	'mow the yard',
	'buy groceries'
];

$limit = 2;

// mysqli call
$result = $mysqli->query('SELECT * FROM table');

$num_rows = $result->num_rows;

$num_pages = ceil($num_rows / $limit);

if (isset($_POST['remove'])) {
	$stmt = $mysqli->prepare("DELETE FROM national_parks WHERE id = ?");

	$stmt->bind_param('i', $_GET['remove']);

	$stmt->execute();
}


if (!empty($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

if ($page > 1) {
	$offset = ($_GET['page'] * $limit) - $limit;
} else {
	$offset = 0;
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<title>Lecture</title>
</head>
<body>
	<h1>Sample todo list</h1>
    <ul>
    	<? foreach ($todoList as $key => $task): ?>
    		<li><?= $task; ?> <button onclick="removebyID(<?= $key; ?>)">Remove</button></li>
    	<? endforeach; ?>
    </ul>

    <form method="POST" id="removeForm" action="lecture.php">
    	<input id="removeID" type="hidden" name="remove" value="">
    </form>
	
	<? if ($page < $num_pages): ?>
		<? $page_no = $page + 1; ?>
		<a href="?page=<?= $page_no; ?>">Next</a>
	<? endif; ?>

    <? if ($page > 1): ?>
    	<? $page_no = $page - 1; ?>
    	<a href="?page=<?= $page_no; ?>">Previous</a>
    <? endif; ?>

    <script>
    	var form = document.getElementById('removeForm');
    	var removeId = document.getElementById('removeID');

    	function removebyID(id) {
    		removeID.value = id;
    		form.submit();
    	}
    </script>
</body>
</html>