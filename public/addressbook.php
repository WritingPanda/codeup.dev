<?php

$address_book = array();
$entries = array();

require_once('classes/address_data_store.php');

// When you return to the code, make sure you use this wisely and test thoroughly
class InvalidInputException extends Exception {}

$adrbook = new AddressDataStore('data/addressbook.csv');
$address_book = $adrbook->read();
$errors = [];

// Error validation
if (!empty($_POST)) {
	$entry = [];
	$entry['name'] = $_POST['name'];
	$entry['address'] = $_POST['address'];
	$entry['city'] = $_POST['city'];
	$entry['state'] = $_POST['state'];
	$entry['zip'] = $_POST['zip'];
	$entry['phone'] = $_POST['phone'];
	
	// Organizing error messages
	foreach ($entry as $key => $value) {
		if (empty($value)) {
			$errors[] = "<p><center><h2><font color='red'>" . ucfirst($key) . " is not found.</font></h2></center></p>";
		} else {
			$entries[] = $value;
		}
	}
	// If there are no errors, go ahead and save the address book
	if (empty($errors)) {
		array_push($address_book, array_values($entries));
		$adrbook->write($address_book);
	}
} 



	// Remove item from address book
	if (isset($_GET['remove'])) {
		$key = $_GET['remove'];
		unset($address_book[$key]);
		$adrbook->write($address_book);
		header('Location: addressbook.php');
		exit(0);
	}

	if (count($_FILES) > 0 && $_FILES['upload']['error'] == 0 && $_FILES['upload']['type'] == 'text/csv') {
		// Receive upload and store it in a folder
		$upload_dir = '/vagrant/sites/codeup.dev/public/uploads/';
		$filename = basename($_FILES['upload']['name']);
		$saved_filename = $upload_dir . $filename;
		move_uploaded_file($_FILES['upload']['tmp_name'], $saved_filename);
		// Read and save uploaded file to be read in the address book app
		$adrbook->filename = $saved_filename;
		$newFileArray = $adrbook->read();
		$combineArray = array_merge($address_book, $newFileArray);
		$adrbook->filename = 'data/addressbook.csv';
		$adrbook->write($combineArray);
		header('Location: addressbook.php');
		exit(0);
	} elseif (count($_FILES) > 0 && $_FILES['upload']['type'] != 'text/csv') {
		echo "<p><h2><font color='red'><strong>ERROR:</strong> File is not a csv file.</font></h2></p>";
	}
?>
<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<link href='http://fonts.googleapis.com/css?family=Coda+Caption:800|Bubbler+One' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="/css/bootstrap-theme.css">
	<link rel="stylesheet" href="/css/addressbkstyle.css" type='text/css'>
	<title>Your Address Book</title>
</head>
<body>
	<center><h1>An Address Book</h1>
		<p>Your contacts:</p>
	<table>
		<tr>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip</th>
			<th>Phone</th>
			<th>Remove</th>
		</tr>
		<?php 
		// Show entries in address book, stripped of tags and shown via HTML special characters
		foreach ($address_book as $key => $entries) {
			echo "<tr>";
			foreach ($entries as $entry) {
				echo "<td>" . htmlspecialchars(strip_tags($entry)) . "</td>";
			}
			echo "<td><button type='button' class='close' aria-hidden='true'><a href=?remove={$key}>&times;</a></button></td>";

		}
		echo "</tr>";

		?>
	</table></center>
	<center><p>Please fill out the fields to enter a new entry in your address book:</p></center>
	<form method='POST' action='addressbook.php'>
		<p style='margin-left:10em;'>
			<label for='name'>Name: </label>
			<input id='name' name='name' type='text' autofocus='autofocus'>
		</p>
		<p style='margin-left:10em;'>
			<label for='address'>Address: </label>
			<input id='address' name='address' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='city'>City: </label>
			<input id='city' name='city' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='state'>State: </label>
			<input id='state' name='state' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='zip'>Zip: </label>
			<input id='zip' name='zip' type='text'>
		</p>
		<p style='margin-left:10em;'>
			<label for='phone'>Phone: </label>
			<input id='phone' name='phone' type='text'>
		</p>
		<p>
			<button class="btn btn-primary" type='submit'>Add Address</button>
		</p>
	</form>
	<form method='POST' enctype='multipart/form-data' action='addressbook.php'>
		<p style='margin-left:10em;'>
			<label for='upload'>Upload a CSV to load into the address book: </label>
			<input id='upload' name='upload' type='file'>
		</p>
		<p>
			<button class="btn btn-primary" type='submit'>Upload</button>
		</p>
	</form>
	<footer>
		<p style="color:#f8f8fa;font-family:Courier">&copy; 2014 <a href="http://writtenbyapanda.tumblr.com" target="_blank">Written by a Panda</a></p>
	</footer>
</body>
</html>