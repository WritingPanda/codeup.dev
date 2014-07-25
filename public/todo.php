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
<!DOCTYPE html>
<html>
    <head>
        <title>TODO List</title>
        <link rel="stylesheet" href="/css/readable_bootstrap.min.css">
    </head>
    <body>

        <div class="container">

            <h2>Todo List</h2>
            <ul>
                <? if (!empty($todoList)): ?>
                    <?php foreach ($todoList as $todos): ?>
                        <li><?= $todos['todo']; ?></li>
                    <?php endforeach ?>
                <? else: ?>
                    <h3>Add some tasks for you to do!</h3>
                <? endif; ?>
            </ul>

            <h3>Do something!</h3>
            
            <form method="POST"  action="todo.php">
                <input id="new_item" type="new_item" name="new_item" autofocus>
                <button>Submit</button>
            </form>
            <?php if ($page > 1): ?>
                <a class="btn btn-link" href="?page=<?= $prevPage; ?>">&#8592; Previous</a>
            <?php endif; ?>

            <?php if ($page <= $numPages): ?>
                <a class="btn btn-link" href="?page=<?= $nextPage; ?>">Next &rarr;</a>
            <?php endif ?>
            
        
        </div>

        <script src="/js/jquery-1.11.0.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script>
            // $('.btnRemove').click(function() {
            //     var todoId = $(this).data('todo');
            //     if (confirm('Are you sure you want to remove the item?')) {
            //         $('#removeId').val(todoId);
            //         $('#removeForm').submit();
            //     };
            // });
        </script>
    </body>
</html>