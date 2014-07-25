<!DOCTYPE HTML>

<?php 

    $todos = [];
    $filename = "data/todo_list.txt";

    function read_file($filename) {
        $handle = fopen($filename, 'r');
        $contents = fread($handle, filesize($filename));
        $contents_array = explode("\n", $contents);
        fclose($handle);
        return $contents_array;
    }

    function save_file($filename, $array) {
        $todo_string = implode("\n", $array);
        file_put_contents($filename, $todo_string);
        header("Location: /lecture.php");
        exit(0);
    }

    $todos = read_file($filename);

    if(!empty($_POST)) {
        array_push($todos, $_POST['todo']);
        save_file($filename, $todos);
        header("Location: /lecture.php");
        exit;
    }

    if (isset($_GET)) {
        
    }

?>

<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
        <title>To Do List</title>
    </head>
    <body>

        <div class="container">

            <h2>Todo List: </h2>
            <div class="row">
                <table class="table table-bordered table-responsive col-md-8">
                    <?php 

                        foreach ($todos as $todo) {
                            echo "<tr><td>" . $todo . "</td><td>Complete</td></tr>";
                        }

                    ?>

                    <a href=""></a>
                </table>
            </div>

            <h3>Add Todo Item</h3>

            <form method="POST" class="form-horizontal" action="/lecture.php">
                <div class="form-group">
                    <label class="control-label col-md-1" for="todo">Todo:</label>
                    <div class="col-md-4">
                        <input type="text" id="todo" name="todo" class="form-control" autofocus>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
            <br>
            <form method="POST" enctype="multipart/form-data" role="form">
                <div class="form-group">
                    <label for="filedata">Upload a file</label>
                    <input type="file" id="filedata" name="filedata">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Submit</button>
                </div>
            </form>

        </div>

        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery-1.11.0.js"></script>

    </body>
</html>