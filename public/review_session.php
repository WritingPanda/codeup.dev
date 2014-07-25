<?php

function getOffset() {
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    return ($page - 1) * 4;
}

$dbc = new PDO('mysql:host=127.0.0.1;dbname=national_parks', 'codeup_omar', 'codeup2014');

$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$query = 'SELECT * FROM parks LIMIT 4 OFFSET ' . getOffset();
$parks = $dbc->query($query)->fetchAll(PDO::FETCH_ASSOC);

$count = $dbc->query('SELECT count(*) FROM parks')->fetchColumn();

$numPages = ceil($count / 4);

if (isset($_GET['page'])) {
    $page = $_GET['page'];
} else {
    $page = 1;
}

$nextPage = $page + 1;
$prevPage = $page - 1;

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>National Parks</title>
</head>
<body>
    <h1>National Parks <small>Parks National</small></h1>

    <table class="table table-striped table-hover">
        <tr>
            <th>Name</th>
            <th>State</th>
            <th>Date Established</th>
            <th>Area in Acres</th>
            <th>Description</th>
        </tr>

        <?php foreach ($parks as $park): ?>
            <tr>
                <td><?= $park['name']; ?></td>
                <td><?= $park['location']; ?></td>
                <td><?= $park['date_established']; ?></td>
                <td><?= $park['area_in_acres']; ?></td>
                <td><?= $park['description']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php if ($page > 1): ?>
        <a href="?page=<?= $prevPage; ?>">&larr; Previous</a>        
    <?php endif; ?>
    
    <?php if ($page < $numPages): ?>
        <a href="?page=<?= $nextPage; ?>">Next &rarr;</a>        
    <?php endif; ?> 









</body>
</html>