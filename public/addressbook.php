<?php

$address_book = array();
$entries = array();

function store_entry($filename, $lines) {
	$handle = fopen($filename, 'a+');
	foreach ($lines as $line) {
		fputcsv($handle, $line);
	}
	fclose($handle);
}

	//  Create a function to store a new entry. 
	// A new entry should have validate 6 required fields: 
	// name, address, city, state, zip, and phone number. 
	// Display error if each is not filled out.

if (!empty($_POST['name'])) {
	if (empty($_POST['name'])){
		$name = $_POST['name'];
		array_push($entries, $name);
	} else {
		echo "<p>Please enter your name.</p>";
	}
}

if (!empty($_POST['address'])) {
	if (empty($_POST['address'])) {
		$address = $_POST['address'];
		array_push($entries, $address);
	} else{
		echo "<p>Please enter your address.</p>";
	}
}

if (!empty($_POST['city'])) {
	if (empty($_POST['city'])) {}
		$city = $_POST['city'];
		array_push($entries, $city);
	} else {
		echo "<p>Please enter your city.</p>";
	}
}

if (!empty($_POST['state'])) {
	if (empty($)_POST['state']) {
		$state = $_POST['state'];
		array_push($entries, $state);	
	} else {
		echo "<p>Please enter your state.</p>";
	}
}

if (!empty($_POST['zip'])) {
	if (empty($_POST['zip'])) {
		$zip = $_POST['zip'];
		array_push($entries, $zip);
	} else {
		echo "<p>Please enter your zip code.</p>";
	}
}

if (!empty($_POST['phone'])) {
	if (empty($_POST['phone'])) {
		$phone = $_POST['phone'];
		array_push($entries, $phone);
	} else {
		echo "<p>Please enter your phone number.</p>";
	}
}

if (!empty($_POST)) {
	$newContent = array_push($address_book, $entries);
	var_dump($newContent);
	store_entry('data/addressbook.csv', $newContent);
}


?>

<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Your Address Book App!</title>
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
	</table>
	<p>Please fill out the fields to enter a new entry in your address book:</p></center>
	<form method='POST' enctype='multipart/form-data' action='addressbook.php'>
		<p>
			<label for='name'>Name: </label>
			<input id='name' name='name' type='text' autofocus='autofocus'>
		</p>
		<p>
			<label for='address'>Address: </label>
			<input id='address' name='address' type='text'>
		</p>
		<p>
			<label for='city'>City: </label>
			<input id='city' name='city' type='text'>
		</p>
		<p>
			<label for='state'>State: </label>
			<input id='state' name='state' type='text'>
		</p>
		<p>
			<label for='zip'>Zip: </label>
			<input id='zip' name='zip' type='text'>
		</p>
		<p>
			<label for='phone'>Phone: </label>
			<input id='phone' name='phone' type='text'>
		</p>
		<p>
			<button type='submit'>Add Address</button>
		</p>
	</form>
</body>
</html>