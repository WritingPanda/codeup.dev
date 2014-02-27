<?php

$filename = 'data/addressbook.csv';
$address_book = array();
$entries = array();

function store_entry($filename, $rows) {
	$handle = fopen($filename, 'w');
	foreach ($rows as $row) {
		fputcsv($handle, $row);
	}
	fclose($handle);
}

function readCSV($filename) {
	$contents = [];
    $handle = fopen($filename, "r");
    while(($data = fgetcsv($handle)) !== FALSE) {
    	$contents[] = $data;
    }
    fclose($handle);
    return $contents;
}

$address_book = readCSV($filename);

if (!empty($_POST)) {
	$name = $_POST['name'];
	$address = $_POST['address'];
	$city = $_POST['city'];
	$state = $_POST['state'];
	$zip = $_POST['zip'];
	$phone = $_POST['phone'];
	$entries = [$name, $address, $city, $state, $zip, $phone];
	array_push($address_book, $entries);
	store_entry($filename, $address_book);
}
?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Your Address Book</title>
</head>
<style>
table,th,td
{
border:1px solid black;
border-collapse:collapse;
}
th,td
{
padding:5px;
}
</style>
<body>
	<center><h1>An Address Book</h1>
		<p>Look how popular you are! These are your contacts:</p>
	<table style='width:800px'>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip</th>
			<th>Phone</th>
		</tr>
		<?php 

		foreach ($address_book as $entries) {
			echo "<tr>";
			foreach ($entries as $entry) {
				echo "<td>" . $entry . "</td>";
			}
		}
		echo "</tr>";
		?>
	</table></center>
	<center><p>Please fill out the fields to enter a new entry in your address book:</p>
	<form method='POST' enctype='multipart/form-data' action='addressbook.php'>
		<p>
			<label for='name'>Name: </label>
			<input id='name' name='name' type='text' autofocus='autofocus' required>

			<label for='address'>Address: </label>
			<input id='address' name='address' type='text' required>
		
			<label for='city'>City: </label>
			<input id='city' name='city' type='text' required>
		
			<label for='state'>State: </label>
			<input id='state' name='state' type='text' required>
		
			<label for='zip'>Zip: </label>
			<input id='zip' name='zip' type='text' required>
		
			<label for='phone'>Phone: </label>
			<input id='phone' name='phone' type='text' required>
		
			<button type='submit'>Add Address</button>
		</p></center>
	</form>
</body>
</html>