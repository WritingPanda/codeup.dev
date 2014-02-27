<?php

$filename = 'data/addressbook.csv';
$address_book = array();
$entries = array();

// class AddressDataStore {
	
// 	public $filename = '';

// 	function readCSV() {
// 		$contents = [];
// 		$handle = fopen($this->filename, "r");
// 		while(($data = fgetcsv($handle)) !== FALSE) {
// 			$contents[] = $data;
// 		}
//     	fclose($handle);
//     	return $contents;
// 	}

// 	function store_entry($rows) {
// 		// Code to write $addresses_array to file $this->filename
// 		$handle = fopen($this->filename, 'w');
// 		foreach ($rows as $row) {
// 			fputcsv($handle, $row);
// 		}
// 		fclose($handle);
// 		}
// }

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

// $adrbk = new AddressDataStore();
// $adrbk->filename = 'data/addressbook.csv';

$address_book = readCSV($filename);
$errors = [];

if (!empty($_POST)) {
	$entry = [];
	foreach ($_POST as $key => $value) {
		if (empty($value)) {
			$errors[] = "<p><center><h2><font color='red'>" . ucfirst($key) . " is not defined.</font></h2></center></p>";
		} else {
			$entry[] = $value;
		}
	}
	if (empty($errors)) {
		array_push($address_book, $entry);
		store_entry($filename, $address_book);
	}
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
			<th>Remove link</th>
		</tr>
		<?php 

		foreach ($address_book as $key => $entries) {
			echo "<tr>";
			foreach ($entries as $entry) {
				echo "<td>" . htmlspecialchars(strip_tags($entry)) . "</td>";
			}
			echo "<td><a href=?remove={$key}>Remove Entry</a></td>";

		}
		echo "</tr>";

		if (isset($_GET['remove'])) {
			$key = $_GET['remove'];
			unset($address_book[$key]);
			store_entry('data/addressbook.csv', $address_book);
			header('Location: addressbook.php');
			exit(0);
		}
		?>
	</table></center>
	<center><p>Please fill out the fields to enter a new entry in your address book:</p>
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
			<button type='submit'>Add Address</button>
		</p></center>
	</form>
	<?php
	if(!empty($errors)){
		foreach ($errors as $message) {
			echo $message;
		}
	}
	?>
</body>
</html>