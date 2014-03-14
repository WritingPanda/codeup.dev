<?php 
	require_once('php/mysqli_call.php');



	if (!empty($_GET) && isset($_GET['sort_column']) && isset($_GET['sort_order'])) {
		$result = $mysqli->query("SELECT name, location, date_established, area_in_acres, description FROM national_parks ORDER BY {$_GET['sort_column']} {$_GET['sort_order']}");
	} else {
    	$result = $mysqli->query("SELECT name, location, date_established, area_in_acres, description FROM national_parks");
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/bootstrap-theme.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<title>National Parks</title>
</head>
<body>
	<div class="page-header">
		<h1>
			<p class="text-center">
			National Parks
			<br>
			<img src="/img/LargeUSFlag.gif">
			</p>
		</h1>
	</div>
	<div class="col-md-10 col-md-offset-1 table-responsive">
		<table class="table table-striped table-bordered">
			<tr class="success">
				<th>
					Name
					<br>
					<a href="?sort_column=name&amp;sort_order=asc"><span class="glyphicon glyphicon-chevron-up"></span></a> <a href="?sort_column=name&amp;sort_order=desc"><span class="glyphicon glyphicon-chevron-down"></span></a>
				</th>
				<th>
					Location
					<br>
					<a href="?sort_column=location&amp;sort_order=asc"><span class="glyphicon glyphicon-chevron-up"></span></a> <a href="?sort_column=location&amp;sort_order=desc"><span class="glyphicon glyphicon-chevron-down"></span></a>
				</th>
				<th>
					Established
					<br>
					<a href="?sort_column=date_established&amp;sort_order=asc"><span class="glyphicon glyphicon-chevron-up"></span></a> <a href="?sort_column=date_established&amp;sort_order=desc"><span class="glyphicon glyphicon-chevron-down"></span></a>
				</th>
				<th>
					Acres
					<br>
					<a href="?sort_column=area_in_acres&amp;sort_order=asc"><span class="glyphicon glyphicon-chevron-up"></span></a> <a href="?sort_column=area_in_acres&amp;sort_order=desc"><span class="glyphicon glyphicon-chevron-down"></span></a>
				</th>
				<th>
					Description
				</th>
			</tr>
				<?php
					while ($row = $result->fetch_array(MYSQLI_NUM)) {
	        			echo "<tr>";
	        			foreach ($row as $park) {
	        				echo "<td>$park</td>";
	    				} echo "</tr>";
	        		}
				?>
		</table>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>