<?php 
	require_once('php/mysqli_call.php');

	$errormsg = "";

	if (!empty($_POST)) {

		if (isset($_POST) &&
			empty($_POST['name']) ||
			empty($_POST['location']) ||
			empty($_POST['date_established']) ||
			empty($_POST['area_in_acres']) ||
			empty($_POST['descripton'])) {
				$errormsg = "<img src='img/007error.gif'><p id='error'>ERROR!</p>";
		} else {
			$stmt = $mysqli->prepare("INSERT INTO national_parks (name, location, date_established, area_in_acres, description) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssds", $_POST['name'], $_POST['location'], $_POST['date_established'], $_POST['area_in_acres'], $_POST['description']);
			$stmt->execute();
		}
	}

	$parks = $mysqli->query("SELECT name, location, date_established, area_in_acres, description FROM national_parks");

	$validCols = ['name','location','date_established','area_in_acres'];
	$sortCol = 'name';
	$sortOrder = 'ASC';

	if (isset($_GET['sort_column']) && in_array($_GET['sort_column'], $validCols)) {
		$sortCol = $_GET['sort_column'];
	}

	if (isset($_GET['sort_order']) && $_GET['sort_order'] == 'desc') {
		$sortOrder = 'DESC';
	}

	$result = $mysqli->query("SELECT name, location, date_established, area_in_acres, description FROM national_parks ORDER BY {$sortCol} {$sortOrder}");	
	
	$mysqli->close();	

?>
<!doctype html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<link rel="stylesheet" href="/css/bootstrap-theme.css">
	<link rel="stylesheet" href="/css/bootstrap.min.css">
	<title>National Parks</title>
	<style>
		#error {
			text-align: center;
			text-shadow: 1px 1px 1px #000000;
			font-weight: bold;
		}
	</style>
</head>
<body>
	<div class="page-header">
		<h1>
			<p class="text-center">
				National Parks in the USA
			</p>
			<p id="error" class="text-center">
				<?= $errormsg; ?>
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
	        			foreach ($row as $parksinfo) {
	        				echo "<td>$parksinfo</td>";
	    				}
	        			echo "</tr>";
	        		}	

				?>
		</table>
	</div>
	<div class="container col-md-11 col-md-offset-1">
		<form method="POST" action="national_parks.php">
			<div class="form-group row col-xs-3">
				<label for="name">National Park</label>
				<input id="name" name="name" type="text" class="form-control" placeholder="Enter name">
			</div>
			<div class="form-group row col-xs-3">
				<label for="location">Location</label>
				<input id="location" name="location" type="text" class="form-control" placeholder="Enter state">
			</div>
			<div class="form-group row col-xs-3">
				<label for="date_established">Established</label>
				<input id="date_established" name="date_established" type="text" class="form-control" placeholder="YYYY-MM-DD">
			</div>
			<div class="form-group row col-xs-3">
				<label for="area_in_acres">Area</label>
				<input id="area_in_acres" name="area_in_acres" type="text" class="form-control" placeholder="Enter acres">
			</div>
			<div class="col-md-8 col-md-offset-4">
				<div class="form-group row col-md-4">
					<label for="description">Description</label>
					<textarea id="description" name="description" class="form-control" rows="3"></textarea>
				</div>
			</div>
			<div class="col-md-6 col-md-offset-5 btn-lg btn-block">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</html>