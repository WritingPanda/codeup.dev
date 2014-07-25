<?php 

// Get new instance of PDO object
$dbc = new PDO('mysql:host=127.0.0.1;dbname=todos', 'codeup_omar', 'codeup2014');

// Tell PDO to throw exceptions on error
$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$todoList = [];
$limit = 5;

function getOffset() {
	if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    return ($page - 1) * 4;
}

$offset =  getOffset();

$query = 'SELECT todo FROM todos LIMIT :limit OFFSET :offset';
$stmt = $dbc->prepare($query);
$stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
$stmt->bindValue(":offset", $offset, PDO::PARAM_INT);
$stmt->execute();

$todoList = $stmt->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT count(*) FROM todos')->fetchColumn();

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$numPages = ceil($count / $limit);

$nextPage = $page + 1;
$prevPage = $page - 1;

?>

<?

// File info
    // require('classes/filestore.php');

// Adding new item && adding to list
    // $array_checker = empty($_POST['new_item']);
    // if (!($array_checker)) {
    //     $todo_list[] = $_POST['new_item'];
    //     $FS->write($todo_list);
    //     header('Location: todo.php');
    // }

// Deleting items
    // if (isset($_GET['removeIndex'])) {
    //     $removeIndex = $_GET['removeIndex'];
    //     unset($todo_list[$removeIndex]);
    //     $FS->write($todo_list);
    //     header('Location: todo.php');
    // }

// Upload New List + Checker
    // if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0 && $_FILES['file1']['type'] !== 'text/plain') {
    //    echo "Incorrect file type. Please use a .txt file type.";
    // } else if (count($_FILES) > 0 && $_FILES['file1']['error'] == 0) {
    //     $upload_dir = '/vagrant/sites/todo.dev/public/uploads/';
    //     $filename_upload = basename($_FILES['file1']['name']);
    //     $saved_filename = $upload_dir . $filename_upload;
    //     move_uploaded_file($_FILES['file1']['tmp_name'], $saved_filename);
    //     $upload = new Filestore($saved_filename);
    //     $new_uploaded_list = $upload->read();
    //     $todo_list = array_merge($todo_list, $new_uploaded_list); 
    //     $FS->write($todo_list);
    // }

?>